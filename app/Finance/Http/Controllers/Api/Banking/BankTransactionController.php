<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;

class BankTransactionController extends Controller
{
    protected $bankTransaction;
    protected $http_response;
    protected $helper;
    protected $practices;
    protected $bankAccounts;
    protected $accountingVouchers;
    protected $suppliers;
    protected $customers;

    public function __construct(BankTransaction $bankTransaction)
    {
        $this->http_response = Config::get('response.http');
        $this->bankTransaction = new FinanceRepository($bankTransaction);
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        $this->accountChartAccount = new AccountingRepository( new AccountChartAccount() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
    }

    public function index(Request $request){}

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'bank_account'=>'required',
            'transactions'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $company = $this->practices->find($request->user()->company_id);
            $bankAccount = $this->bankAccounts->findByUuid($request->bank_account);
            $bank_ledger_account = $bankAccount->ledger_accounts()->get()->first();
            
            $new_transaction_array = array();
            $exist_transaction_array = array();

            if($request->has('action_taken')){
                switch($request->action_taken){
                    case "Save":
                        $missing = 0;
                        if( is_array($request->transactions) ){
                            $transactions = $request->transactions;
                            for ($i=0; $i < sizeof($transactions); $i++) {
                                $tranction = $transactions[$i];
                                //Ensure every field is provided in transaction
                                if( ($tranction['id']=='') && ($tranction['transaction_date']=='' || $tranction['payee']=='' || $tranction['description']=='' || $tranction['type']=='' || $tranction['selection']=='' || $tranction['reference']=='') ){
                                    $transactions[$i]['error'] = true;
                                    $transactions[$i]['error_msg'] = "This row!";
                                    $transactions[$i]['is_date'] = true;
                                    //Rollback & Report
                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                                    $http_resp = $this->http_response['422'];
                                    $http_resp['errors'] = $transactions;
                                    return response()->json($http_resp,422);
                                }else{
                                    //Transaction inputs provided so process it
                                    //Check if Transaction "id" is not null and do basic updates
                                    //If Transaction has "id" is NULL
                                    if( $transactions[$i]['id'] == null ){ //Create New Transaction

                                        // $inputs['transaction_date'] = $transactions[$i]['transaction_date'];
                                        // $inputs['reference'] = $transactions[$i]['reference'];
                                        // $inputs['bank_account_id'] = $bankAccount->id;
                                        // $inputs['payee'] = $transactions[$i]['payee'];
                                        // $inputs['description'] = $transactions[$i]['description'];
                                        // $inputs['type'] = $transactions[$i]['type'];
                                        // $inputs['discount'] = $transactions[$i]['discount'];
                                        // $inputs['comment'] = $transactions[$i]['comment'];
                                        $transactions[$i]['bank_account_id'] = $bankAccount->id;
                                        $transacted = $this->bankTransaction->create($transactions[$i]);
                                        //Create New Transaction
                                        //Create Double Entry Ledger
                                        //Link The Ledger to Account Holders
                                        //Link The transaction to: Supplier, Customer, Bank Account, Account or VAT depending on what User Selected,
                                        //Set Initial Status and Responsible Company User Create This
                                        //Update Account Holder Balance
                                        //Update BankAccount Balance
                                        //Check if Paying Supplier and Discount was Allowed
                                        /*
                                            If Transaction is:
                                                1. Supplier Payment: Get Accounts Payables
                                        */
                                        $spent = $transactions[$i]['spent'];
                                        $type_ = $transactions[$i]['type'];
                                        $discount = $transactions[$i]['discount'];
                                        $comment = $transactions[$i]['comment'];
                                        $as_at = $transactions[$i]['transaction_date'];
                                        $trans_name = $transactions[$i]['description'];
                                        $reference_number = $transactions[$i]['reference'];
                                        
                                        switch( $type_ ){

                                            case AccountsCoa::AC_TYPE_SUPPLIER:
                                                //Here "spent" parameter must be provided
                                                if($spent == null){
                                                    //Create message to display to user interface
                                                    $transactions[$i]['error'] = true;
                                                    $transactions[$i]['error_msg'] = "Amount!";
                                                    $transactions[$i]['is_spent'] = true;
                                                    //RollBack DB and Return response 422
                                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                                                    $http_resp = $this->http_response['422'];
                                                    $http_resp['errors'] = $transactions;
                                                    return response()->json($http_resp,422);
                                                }
                                                $transacted->spent = $spent;
                                                $transacted->save();
                                                $amount = $transactions[$i]['spent'];
                                                $transaction_id = $this->helper->getToken(10,'PAY');
                                                if( $discount ){
                                                    $amount = $amount - $discount;
                                                }
                                                //Get Company Accounts Payables
                                                //ASSET and EXPENSE accounts have normal debit balances. Debited when Increase, Credited when Decrease
                                                //Liability, equity and revenue have normal Credit Balance: i.e Credited when Increase, Debited when Descrease
                                                //Get Supplier by uuid
                                                $supplier = $this->suppliers->findByUuid($transactions[$i]['selection']['id']);
                                                //Get Supplier Account from AccountHolders and Reduce the balance since is being 
                                                $supplier_account = $supplier->account_holders()->get()->first();
                                                $account_holder_number = $supplier_account->account_number;
                                                $supplier_account->balance = $supplier_account->balance - $amount;
                                                $supplier_account->save();
                                                //Bank Account Balance Update
                                                $bankAccount->balance = $bankAccount->balance - $amount;
                                                $bankAccount->save();
                                                //Link Supplier to Transaction via Transactionable:
                                                $transacted = $supplier->bank_transactions()->save($transacted);
                                                $company_accounts_payable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_PAYABLE_CODE)->get()->first();
                                                $trans_type = AccountsCoa::TRANS_TYPE_SUPPLIER_PAYMENT;
                                                $debited_ac = $company_accounts_payable->code;
                                                $credited_ac = $bank_ledger_account->code;
                                                //
                                                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                                                $support_doc = $double_entry->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number]);
                                                //Link Support Document to Transactionable: this can be "Bank Transaction", "Invoice","Bill" etc
                                                $support_doc = $transacted->double_entry_support_document()->save($support_doc);
                                                //Also Perform Double Entry for Discount we Received
                                                if( $discount ){
                                                    //Get Companies Discount/Received or Refund
                                                    //Discount Received is an Income/Revenue so it has "Normal Credit Balance"
                                                    $trans_type = AccountsCoa::TRANS_TYPE_DISCOUNT_RECEIVED;
                                                    $trans_name = $comment;
                                                    $transaction_id = $this->helper->getToken(10,'DISC');
                                                    $company_discount_received_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                    $debited_ac = $company_accounts_payable->code;
                                                    $credited_ac = $company_discount_received_account->code;
                                                    $double_entry2 = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$discount,$as_at,$trans_name,$transaction_id);
                                                    $support_doc2 = $double_entry2->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number]);
                                                    $support_doc2 = $transacted->double_entry_support_document()->save($support_doc2);
                                                    $supplier_account->balance = $supplier_account->balance - $discount;
                                                    $supplier_account->save();
                                                    //Bank Account Balance Update
                                                    $bankAccount->balance = $bankAccount->balance - $discount;
                                                    $bankAccount->save();
                                                }
                                            break;
                                            case AccountsCoa::AC_TYPE_CUSTOMER: //We Receive from the customer payment
                                                if($transactions[$i]['received'] == null){
                                                    //Create message to display to user interface
                                                    $transactions[$i]['error'] = true;
                                                    $transactions[$i]['error_msg'] = "Amount received!";
                                                    $transactions[$i]['is_received'] = true;
                                                    //RollBack DB and Return response 422
                                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                                                    $http_resp = $this->http_response['422'];
                                                    $http_resp['errors'] = $transactions;
                                                    return response()->json($http_resp,422);
                                                }
                                                //
                                                $amount = $transactions[$i]['received'];
                                                if( $discount ){
                                                    //Discount is Income/Revenue, so it has "credit balances"
                                                    $amount = $amount - $discount;
                                                    $trans_name = $comment;
                                                }

                                                //Get Customer by uuid
                                                $customer = $this->customers->findByUuid($transactions[$i]['selection']['id']);
                                                //Get Supplier Account from AccountHolders and Reduce the balance since is being 
                                                $customer_account = $customer->account_holders()->get()->first();
                                                $account_holder_number = $customer_account->account_number;
                                                $customer_account->balance = $customer_account->balance - $amount;
                                                $customer_account->save();
                                                //Bank Account Balance Update
                                                $bankAccount->balance = $bankAccount->balance - $amount;
                                                $bankAccount->save();

                                                
                                                Log::info("============");
                                                $transacted->received = $amount;
                                                $transacted->save();
                                                $transaction_id = $this->helper->getToken(10,'PAI');
                                                
                                                $trans_type = AccountsCoa::TRANS_TYPE_CUSTOMER_RECEIPT;
                                                $transaction_id = $this->helper->getToken(10,'REC');
                                                $company_accounts_receivable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
                                                //$company_discount_given_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                $debited_ac = $bank_ledger_account->code;
                                                $credited_ac = $company_accounts_receivable->code;
                                                /*
                                                    TR 1: Credit A/R & Dedit "This Bank Ledger Account" by $amount
                                                    TR 2: Debit "Discount" & Credit A/R
                                                */

                                                //Transaction 
                                                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                                                $support_doc = $double_entry->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,
                                                    'account_number'=>$account_holder_number,
                                                    'reference_number'=>$reference_number]);
                                                //Link Support Document to Transactionable: this can be "Bank Transaction", "Invoice","Bill" etc
                                                $support_doc = $transacted->double_entry_support_document()->save($support_doc);


                                                //Transaction 2: If discount was allowed
                                                if($discount > 0){
                                                    //Discount Received is an Income/Revenue so it has "Normal Credit Balance"
                                                    $trans_type = AccountsCoa::TRANS_TYPE_DISCOUNT_ALLOWED;
                                                    $trans_name = $comment;
                                                    $transaction_id = $this->helper->getToken(10,'DISC');
                                                    $company_discount_given_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                    $debited_ac = $company_discount_given_account->code;
                                                    $credited_ac = $company_accounts_receivable->code;
                                                    $double_entry2 = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$discount,$as_at,$trans_name,$transaction_id);
                                                    $support_doc2 = $double_entry2->support_documents()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number]);
                                                    $support_doc2 = $transacted->double_entry_support_document()->save($support_doc2);
                                                    $customer_account->balance = $customer_account->balance - $discount;
                                                    $customer_account->save();
                                                    //Bank Account Balance Update
                                                    $bankAccount->balance = $bankAccount->balance - $discount;
                                                    $bankAccount->save();
                                                }

                                            break;
                                        }

                                    }else{ //Get Transaction and do basic update
                                        //SPECIAL EDITS: amount,type,selection,status(reconciled)
                                        $transacted = $this->bankTransaction->findByUuid($transactions[$i]['id']);
                                        $inputs = [];
                                        $inputs['transaction_date'] = $transactions[$i]['transaction_date'];
                                        $inputs['reference'] = $transactions[$i]['reference'];
                                        $inputs['payee'] = $transactions[$i]['payee'];
                                        $inputs['description'] = $transactions[$i]['description'];
                                        $transacted = $this->bankTransaction->update($inputs,$transacted->id);
                                    }
                                }
                            }
                        }
                    break;
                }
            }
            $http_resp['description'] = "Transactions successful saved!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $company = $this->practices->find($request->user()->company_id);
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->bankTransaction->transform_bank_transaction($this->bankTransaction->findByUuid($uuid),$company);
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){}

    public function destroy($uuid){}

}

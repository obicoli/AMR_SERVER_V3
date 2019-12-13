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
use App\Models\Account\Account;
use App\Models\Practice\PracticeUser;
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
    protected $companyUsers;

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
        $this->companyUsers = new PracticeRepository(new PracticeUser());
    }

    public function index(Request $request){

        Log::info($request);
        $company = $this->practices->find($request->user()->company_id);
        $filters = $this->helper->get_default_filter();
        if($request->has('bank_account_id')){
            $bankAccount = $this->bankAccounts->findByUuid($request->bank_account_id);
            if($request->has('status')){
                $status = $request->status;
                $bank_transactions = $bankAccount->bank_transactions()
                    ->where('status',$status)
                    ->whereRaw("transaction_date >= ? AND transaction_date <= ?",$filters)
                    ->orderByDesc('created_at')
                    ->paginate(15);
            }
        }
        $paged_data = $this->helper->paginator($bank_transactions);
        $paged_data['filters'] = $filters;
        foreach($bank_transactions as $bank_transaction){
            array_push($paged_data['data'], $this->bankAccounts->transform_bank_transaction($bank_transaction,$company));
        }
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);

    }

    public function create(Request $request){


        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'bank_account_id'=>'required',
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
            $bankAccount = $this->bankAccounts->findByUuid($request->bank_account_id);
            $bank_ledger_account = $bankAccount->ledger_accounts()->get()->first();
            $user = $request->user();
            $companyUser = $this->companyUsers->findByUserAndCompany($user,$company);
            
            // $new_transaction_array = array();
            // $exist_transaction_array = array();


            if($request->has('action_taken')){
                //---------------------------------------------------------------------------------------
                switch($request->action_taken){
                    case "Save":
                        $missing = 0;
                        if( is_array($request->transactions) ){
                            $transactions = $request->transactions;
                            for ($i=0; $i < sizeof($transactions); $i++) {




                                $tranction = $transactions[$i];
                                $transaction_id_ = $tranction['id'];
                                $type_ = $tranction['type'];
                                $transaction_date_ = $tranction['transaction_date'];
                                $description_ = $tranction['description'];
                                $selection_ = $tranction['selection'];
                                $reference_ = $tranction['reference'];
                                $payee_ = $tranction['payee'];
                                $received_ = $tranction['received'];
                                $spent_ = $tranction['spent'];
                                $vat_ = $tranction['vat'];
                                //$rec_ = $tranction['rec'];
                                $amount = 0;
                                $trans_date = $this->helper->format_lunox_date($tranction['transaction_date']);
                                //Ensure every field is provided in transaction
                                if( ($transaction_id_=='') && ($transaction_date_=='' || $description_=='' || $type_=='' || $selection_=='' || $reference_=='' || $payee_=='') ){
                                    $transactions[$i]['error'] = true;
                                    $transactions[$i]['error_msg'] = "Missing!";
                                    $transactions[$i]['is_date'] = $this->validate_array_inputs($transaction_date_);
                                    $transactions[$i]['is_desc'] = $this->validate_array_inputs($description_);
                                    $transactions[$i]['is_type'] = $this->validate_array_inputs($type_);
                                    $transactions[$i]['is_select'] = $this->validate_array_inputs($selection_);
                                    //$transactions[$i]['is_ref'] = $this->validate_array_inputs($reference_);
                                    $transactions[$i]['is_payee'] = $this->validate_array_inputs($payee_);
                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                                    $http_resp = $this->http_response['422'];
                                    $http_resp['errors'] = ['Missing payload'];
                                    $http_resp['err_array'] = $transactions;
                                    return response()->json($http_resp,422);
                                }else{
                                    //Transaction inputs provided so process it
                                    //Check if Transaction "id" is not null and do basic updates
                                    //If Transaction has "id" is NULL
                                    if( $transaction_id_ == null ){ //Create New Transaction

                                        // $transactions[$i]['bank_account_id'] = $bankAccount->id;
                                        // $transactions[$i]['transaction_date'] = $this->helper->format_lunox_date($transactions[$i]['transaction_date']);
                                        // $transacted = $this->bankTransaction->create($transactions[$i]);

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
                                                $supplier = $this->suppliers->findByUuid($transactions[$i]['selection']['id']);
                                                $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
                                                $transactions[$i]['bank_account_id'] = $bankAccount->id;
                                                $transactions[$i]['transaction_date'] = $trans_date;
                                                $transacted = $supplier->bank_transactions()->create($transactions[$i]);

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
                                                //$company_accounts_payable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_PAYABLE_CODE)->get()->first();
                                                $trans_type = AccountsCoa::TRANS_TYPE_SUPPLIER_PAYMENT;
                                                $debited_ac = $supplier_ledger_ac->code;
                                                $credited_ac = $bank_ledger_account->code;
                                                //
                                                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                                                $support1['trans_type'] = $trans_type;
                                                $support1['trans_name'] = $trans_name;
                                                $support1['account_number'] = $account_holder_number;
                                                $support1['reference_number'] = $reference_number;
                                                $support1['voucher_id'] = $double_entry->id;
                                                $support_doc = $transacted->double_entry_support_document()->create($support1);
                                                //Link Support Document to Transactionable: this can be "Bank Transaction", "Invoice","Bill" etc
                                                //$support_doc = $transacted->double_entry_support_document()->save($support_doc);

                                                //Also Perform Double Entry for Discount we Received
                                                if( $discount ){
                                                    //Get Companies Discount/Received or Refund
                                                    //Discount Received is an Income/Revenue so it has "Normal Credit Balance"
                                                    $trans_type = AccountsCoa::TRANS_TYPE_DISCOUNT_RECEIVED;
                                                    $trans_name = $comment;
                                                    $transaction_id = $this->helper->getToken(10,'DISC');
                                                    $company_discount_received_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                    $debited_ac = $supplier_ledger_ac->code;
                                                    $credited_ac = $company_discount_received_account->code;
                                                    $double_entry2 = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$discount,$as_at,$trans_name,$transaction_id);
                                                    $support_doc2 = $transacted->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number,'voucher_id'=>$double_entry2->id]);
                                                    //$support_doc2 = $transacted->double_entry_support_document()->save($support_doc2);
                                                    $supplier_account->balance = $supplier_account->balance - $discount;
                                                    $supplier_account->save();
                                                    //Bank Account Balance Update
                                                    $bankAccount->balance = $bankAccount->balance - $discount;
                                                    $bankAccount->save();
                                                }
                                                //Attach this bank transaction to an Open Bank Reconciliation as Below:
                                                //1. Get available Reconciliation by line below
                                                $bank_account_reconciliation = $this->bankTransaction->getOrCreateBankReconciliation($bankAccount,$trans_date,null);
                                                $this->bankTransaction->reconcile_bank_transaction($companyUser,$bank_account_reconciliation,$transacted,$bankAccount,null);
                                            break;


                                            case AccountsCoa::AC_TYPE_CUSTOMER: //We Receive from the customer payment
                                                if($transactions[$i]['received'] == null){
                                                    //Create message to display to user interface
                                                    //
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

                                                $customer = $this->customers->findByUuid($transactions[$i]['selection']['id']);
                                                $transactions[$i]['bank_account_id'] = $bankAccount->id;
                                                $transactions[$i]['transaction_date'] = $this->helper->format_lunox_date($transactions[$i]['transaction_date']);
                                                // $transacted = $this->bankTransaction->create($transactions[$i]);
                                                $transacted = $customer->bank_transactions()->create($transactions[$i]);
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
                                                $transacted->received = $amount;
                                                $transacted->save();
                                                $transaction_id = $this->helper->getToken(10,'PA');
                                                
                                                $trans_type = AccountsCoa::TRANS_TYPE_CUSTOMER_RECEIPT;
                                                $transaction_id = $this->helper->getToken(10,'REC');
                                                //$company_accounts_receivable = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_RECEIVABLE_CODE)->get()->first();
                                                //$company_discount_given_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                $customer_ledger_ac = $customer->ledger_accounts()->get()->first();
                                                $debited_ac = $bank_ledger_account->code;
                                                $credited_ac = $customer_ledger_ac->code;
                                                /*
                                                    TR 1: Credit A/R & Dedit "This Bank Ledger Account" by $amount
                                                    TR 2: Debit "Discount" & Credit A/R
                                                */

                                                //Transaction 
                                                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                                                $support_doc = $transacted->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,
                                                    'account_number'=>$account_holder_number,
                                                    'reference_number'=>$reference_number,
                                                    'voucher_id'=>$double_entry->id
                                                    ]);
                                                //Link Support Document to Transactionable: this can be "Bank Transaction", "Invoice","Bill" etc
                                                //$support_doc = $transacted->double_entry_support_document()->save($support_doc);


                                                //Transaction 2: If discount was allowed
                                                if($discount > 0){
                                                    //Discount Received is an Income/Revenue so it has "Normal Credit Balance"
                                                    $trans_type = AccountsCoa::TRANS_TYPE_DISCOUNT_ALLOWED;
                                                    $trans_name = $comment;
                                                    $transaction_id = $this->helper->getToken(10,'DISC');
                                                    $company_discount_given_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE)->get()->first();
                                                    $debited_ac = $company_discount_given_account->code;
                                                    $credited_ac = $customer_ledger_ac->code;
                                                    $double_entry2 = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$discount,$as_at,$trans_name,$transaction_id);

                                                    $support_doc2 = $transacted->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number,'voucher_id'=>$double_entry2->id]);
                                                    $support_doc2 = $transacted->double_entry_support_document()->save($support_doc2);
                                                    $customer_account->balance = $customer_account->balance - $discount;
                                                    $customer_account->save();
                                                    //Bank Account Balance Update
                                                    $bankAccount->balance = $bankAccount->balance - $discount;
                                                    $bankAccount->save();
                                                }
                                                //Attach this bank transaction to an Open Bank Reconciliation as Below:
                                                //1. Get available Reconciliation by line below
                                                $bank_account_reconciliation = $this->bankTransaction->getOrCreateBankReconciliation($bankAccount,$trans_date,null);
                                                $this->bankTransaction->reconcile_bank_transaction($companyUser,$bank_account_reconciliation,$transacted,$bankAccount,null,null);
                                            break;




                                            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                                        }

                                    }else{ //Get Transaction and do basic update
                                        //SPECIAL EDITS: amount,type,selection,status(reconciled)
                                        $transacted = $this->bankTransaction->findByUuid($transactions[$i]['id']);
                                        $inputs = [];
                                        $inputs['transaction_date'] = $trans_date;
                                        $inputs['reference'] = $transactions[$i]['reference'];
                                        $inputs['payee'] = $transactions[$i]['payee'];
                                        $inputs['description'] = $transactions[$i]['description'];
                                        $transacted = $this->bankTransaction->update($inputs,$transacted->id);
                                    }
                                }
                            }
                        }
                    break;
                    //---------------------------------------------------------------------------------------
                    case AccountsCoa::RECONCILIATION_TICKED: //User wants to mark the selected Transactions as Reviewed

                        $rules = [
                            'bank_account_id'=>'required',
                            'selected_transactions'=>'required',
                        ];
                        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
                        if ($validation->fails()){
                            $http_resp = $this->http_response['422'];
                            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                            return response()->json($http_resp,422);
                        }

                        if( is_array($request->selected_transactions) ){
                            //1. Get available Reconciliation by line below
                            //$bank_account_reconciliation = $this->bankTransaction->getOrCreateBankReconciliation($bankAccount,$trans_date,null);
                            //$this->bankTransaction->reconcile_bank_transaction($companyUser,$bank_account_reconciliation,$transacted,$bankAccount,null);
                            $selected_transactions = $request->selected_transactions;
                            for ($i=0; $i < \sizeof($selected_transactions); $i++) {
                                //Get Bank Transaction
                                $bank_transaction = $this->bankTransaction->findByUuid($selected_transactions[$i]);
                                //Log::info($bank_transaction);
                                if($bank_transaction){
                                    //Log::info($selected_transactions);
                                    //Log::info($bank_transaction);
                                    $this->bankTransaction->reviewBankTransaction($bank_transaction,$companyUser,AccountsCoa::RECONCILIATION_TICKED);
                                }
                                // Log::info($bank_transaction);
                                // //Get Reconciled Transaction
                                // $reconciled_transaction = $bank_transaction->reconciled_transactions()->get()->first();
                                // //Get Bank Reconciliation
                                // $bank_reconciliation = $reconciled_transaction->bank_reconciliations()->get()->first();
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

    public function validate_array_inputs($input){
        if($input == ""){
            return true;
        }else{
            return false;
        }
    }

}

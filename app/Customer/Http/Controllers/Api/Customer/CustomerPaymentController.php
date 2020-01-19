<?php

namespace App\Customer\Http\Controllers\Api\Customer;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Models\CustomerPayment;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Repositories\CustomerRepository;
use App\Http\Controllers\Controller;
use App\helpers\HelperFunctions;
use App\Models\Account\Account;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice\PracticeUser;
use App\Finance\Repositories\FinanceRepository;
use App\Finance\Models\Banks\AccountsBank;
use App\Models\Product\Product;
use App\Finance\Models\Banks\BankTransaction;

class CustomerPaymentController extends Controller
{
    //
    protected $customerPayment;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $countries;
    protected $customer_terms;
    protected $payment_methods;
    protected $accountingVouchers;
    protected $taxations;
    protected $accountChartAccount;
    protected $customers;
    protected $company_users;
    protected $bankAccounts;
    protected $customerInvoices;
    protected $bankTransactions;
    protected $accountDoubleEntries;
    protected $customerRetainerInvoices;

    public function __construct( CustomerPayment $customerPayment )
    {
        $this->customerPayment = new CustomerRepository($customerPayment);
        $this->customerRetainerInvoices = new CustomerRepository( new CustomerRetainerInvoice() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice());
        $this->customer_terms = new CustomerRepository(new CustomerTerms());
        $this->payment_methods = new AccountingRepository(new AccountPaymentType());
        $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
        $this->countries = new AccountingRepository( new Country() );
        $this->taxations = new ProductReposity( new ProductTaxation() );
        $this->accountChartAccount = new AccountingRepository(new AccountChartAccount());
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        $this->customerInvoices = new CustomerRepository( new CustomerInvoice() );
        $this->bankTransactions = new FinanceRepository( new BankTransaction() );
        //$this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $customerpayments = $company->customer_payments()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($customerpayments);
        foreach($customerpayments as $customerpayment){
            array_push($results,$this->customerPayment->transform_payment($customerpayment));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
        $inputs = $request->all();
        $pay_mode_cheque = AccountsCoa::PAY_METHOD_CHEQUE;
        $pay_mode_cash = AccountsCoa::PAY_METHOD_CASH;
        $http_resp = $this->http_response['200'];
        $rule = [
            'trans_date'=>'required',
            'payment'=>'required',
            'notes'=>'required',
            'customer_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //Input validations
        $rule = [
            'payment_method'=>'required',
            'cash_paid'=>'required',
        ];
        $validation = Validator::make($request->payment,$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //Input validations
        $payment_mode = $request->payment['payment_method'];
        if( $payment_mode == $pay_mode_cheque ){
            $rule = [
                'bank_account_id'=>'required',
                'cheque_number'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
        }else{
            $rule = [
                'ledger_account_id'=>'required',
                'reference_number'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
        }
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first();
            $company_user = $this->company_users->findByUserAndCompany($user,$company); //Get current user
            $customer = $this->customers->findByUuid($request->customer_id);
            $customer_ledger_ac = $customer->ledger_accounts()->get()->first();
            $finance_settings = $company->practice_finance_settings()->get()->first();
            $cash_paid = $request->payment['cash_paid'];
            $customer_invoice = null;
            $notes = $request->notes;
            $as_at = $this->helper->format_lunox_date($request->trans_date);
            $payment_method = $payment_mode;
            $pay_reference = null;
            $currency = $request->currency;
            //
            $account_type_customer = AccountsCoa::AC_TYPE_CUSTOMER;
            $trans_type_customer_payment = AccountsCoa::TRANS_TYPE_CUSTOMER_PAYMENT;
            $trans_type_customer_deposit = AccountsCoa::TRANS_TYPE_CUSTOMER_DEPOSIT;
            $unearned_revenue_ac_code = AccountsCoa::AC_CUSTOMER_OVERPAYMENT_CODE;
            $customer_trust_account_code = AccountsCoa::AC_CUSTOMER_TRUST_ACCOUNT_CODE;
            $customer_trust_ledger_ac = $company->chart_of_accounts()->where('default_code',$customer_trust_account_code)->get()->first();
            $unearned_revenue_ledger_ac = $company->chart_of_accounts()->where('default_code',$unearned_revenue_ac_code)->get()->first();
            $paid_status = Product::STATUS_PAID;
            $partial_paid_status = Product::STATUS_PARTIAL_PAID;
            //Retainer Invoice Check
            $customer_deposit = false;
            $customer_invoice_payment = false;
            $retainer_invoice = $this->customerRetainerInvoices->findByUuid($request->retainer_invoice_id);
            
            if($retainer_invoice){
                $customer_deposit = true;
            }else{
                $customer_invoice_payment = true;
            }
            //
            $ledger_account_received_payment = null;
            if($finance_settings){
                $payment_prefix = "RCP";
                $bill_prefix = $finance_settings->bill_prefix;
            }else{
                $payment_prefix = "RCP";
                $bill_prefix = "BL";
            }
            //
            $bank_account = null;
            if( $payment_mode == $pay_mode_cheque ){
                $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
                $bank_ledger_account = $bank_account->ledger_accounts()->get()->first();
                $ledger_account_received_payment = $bank_ledger_account;
                $pay_reference = $request->payment['cheque_number'];
            }else{
                $ledger_account = $this->accountChartAccount->findByUuid($request->payment['ledger_account_id']);
                $ledger_account_received_payment = $ledger_account;
                $pay_reference = $request->payment['reference_number'];
            }

            //Record this payment into Payments table as below
            //$notes = "Payment for Invoice ".$new_invoice->trans_number;
            $cash_paid = $request->payment['cash_paid'];
            //$pay_reference = $new_invoice->trans_number;
            $pay_inputs['amount'] = $cash_paid;
            //$pay_inputs['customer_invoice_id'] = $new_invoice->id;
            $pay_inputs['customer_id'] = $customer->id;
            $pay_inputs['trans_date'] = $as_at;
            $pay_inputs['ledger_account_id'] = $ledger_account_received_payment->id;
            //$pay_inputs['payment_method'] = $payment_method;
            $pay_inputs['notes'] = $notes;
            $pay_inputs['reference_number'] = $pay_reference;
            $pay_inputs['trans_number'] = $payment_prefix;
            $new_customer_payment = $company->customer_payments()->create($pay_inputs);
            $new_customer_payment->trans_number = $this->helper->create_transaction_number($payment_prefix,$new_customer_payment->id);
            $new_customer_payment->save();

            $cash_paid_cons = $cash_paid;
            $invoice_amount = $cash_paid;
            if( $request->has('paid_invoices') && ($customer_deposit==false) ){
                $paid_invoices = $request->paid_invoices;
                for( $i=0; $i<sizeof($paid_invoices); $i++){
                    $invoice = $this->customerInvoices->findByUuid($paid_invoices[$i]);
                    if( $cash_paid_cons > 0){
                        $net_total = $invoice->net_total;
                        $total_payment = $invoice->paymentItems()->sum('paid_amount');
                        $status_inputs['notes'] = "Payment of ".$currency." ".number_format($cash_paid,2)." made";
                        $balance_to_pay = $net_total - $total_payment;
                        if( $cash_paid_cons >= $balance_to_pay  ){
                            $status_inputs['status'] = $paid_status;
                            $cash_paid_cons -= $balance_to_pay;
                            $paid_cons = $balance_to_pay;
                        }else{
                            $status_inputs['status'] = $partial_paid_status;
                            $paid_cons = $cash_paid_cons;
                            $cash_paid_cons = 0;
                        }
                        //
                        $invoice_status = $company_user->customer_invoice_status()->create($status_inputs);
                        $invoice_status = $invoice->invoiceStatus()->save($invoice_status);
                        $invoice->status = $status_inputs['status'];
                        $invoice->save();
                        //Create Payment Item as below
                        $item_inputs['customer_invoice_id'] = $invoice->id;
                        $item_inputs['customer_payment_id'] = $new_customer_payment->id;
                        $item_inputs['paid_amount'] = $paid_cons;
                        $invoice_payment = $invoice->paymentItems()->create($item_inputs);
                    }
                }
            }else{//Here you Handle Customer Deposit
                if($customer_deposit){
                    //cash_paid_cons
                    $net_retainer = $retainer_invoice->net_total;
                    $total_payment = $retainer_invoice->paymentItems()->sum('paid_amount');
                    //Log::info($total_payment);
                    if( ($cash_paid_cons+$total_payment) > $net_retainer ){
                        $statu_inputs['status'] = $paid_status;
                    }else{
                        $statu_inputs['status'] = $partial_paid_status;
                    }
                    $statu_inputs['notes'] = "Customer deposit of ".$currency." ".number_format($cash_paid,2)." made";
                    $retainer_status = $company_user->retainer_invoice_status()->create($statu_inputs);
                    $retainer_status = $retainer_invoice->invoiceStatus()->save($retainer_status);
                    $retainer_invoice->status = $statu_inputs['status'];
                    $retainer_invoice->save();
                    //Create Payment Item as below
                    $ite_input['customer_retainer_id'] = $retainer_invoice->id;
                    $ite_input['customer_payment_id'] = $new_customer_payment->id;
                    $ite_input['paid_amount'] = $cash_paid_cons;
                    $retainer_payment = $retainer_invoice->paymentItems()->create($ite_input);
                    // Log::info($retainer_payment);
                    // Log::info($retainer_invoice->id);
                    // Log::info($total_payment = $retainer_invoice->paymentItems()->sum('paid_amount'));
                }
            }

            //Bank was used to for this payment so record bank transaction
            if($bank_account){
                //Bank Transaction recorded below:
                $received = $cash_paid;
                $account_type_customer = AccountsCoa::AC_TYPE_CUSTOMER;
                $trans_type_customer_payment = $trans_type_customer_payment;
                $bank_reference = $request->payment['cheque_number'];
                $discount_allowed = 0;
                $notes = "Customer Payment ".$new_customer_payment->trans_number;
                //Bank Transaction is Recorded
                /*
                    Any Bank Transaction Recorded to the system, 
                    "reference_number" must be an issued reference number 
                    from the bank institution, this is important when it comes to bank reconciliation
                */
                $transactions['bank_account_id'] = $bank_account->id;
                $transactions['transaction_date'] = $as_at;
                $transactions['received'] = $received;
                $transactions['type'] = $account_type_customer;
                $transactions['name'] = $trans_type_customer_payment;
                $transactions['payee'] = $customer->legal_name;
                $transactions['description'] = $notes;
                $transactions['reference'] = $bank_reference;
                $transactions['discount'] = $discount_allowed;
                $transactions['comment'] = $notes;
                $bank_transaction = $new_customer_payment->bank_transactions()->create($transactions);//Create and Link this transaction to Customer Payments
                $bank_transaction = $company->bank_transactions()->save($bank_transaction);//Link transaction to a company
                $bank_account_reconciliation = $this->bankTransactions->getOrCreateBankReconciliation($bank_account,$as_at,null);
                $this->bankTransactions->reconcile_bank_transaction($company_user,$bank_account_reconciliation,$bank_transaction,$bank_account,null,AccountsCoa::RECONCILIATION_NOT_TICKED);
            }

            //ACCOUNTING DOUBLE ENTRIES STARTS HERE
            //Check if Overpayment/unlocated and do accounting Entries
            if($customer_deposit){
                $ledger_support_document = $new_customer_payment->double_entry_support_document()->create(['trans_type'=>$trans_type_customer_deposit]);
            }else{
                $ledger_support_document = $new_customer_payment->double_entry_support_document()->create(['trans_type'=>$trans_type_customer_payment]);
            }
            
            //Excess Amount Journal Entries
            if($cash_paid_cons > 0){
                //There is unlocated amount

                // $company_unlocated_deposit_ledger_ac = $company->chart_of_accounts()->where('default_code',$over_payment_ac_code)->get()->first();
                // $customer_unlocated_ledger_ac = $customer->ledger_accounts()->where('default_code',$over_payment_ac_code)->get()->first();
                // if(!$customer_unlocated_ledger_ac){
                //     //create_sub_chart_of_account(Practice $company, AccountChartAccount $mainAccount, $inputs=[], Model $account_owner)
                //     $unlo_inputs['name'] = $customer->legal_name." - Unlocated deposits";
                //     $customer_unlocated_ledger_ac = $this->accountChartAccount->create_sub_chart_of_account($company,$company_unlocated_deposit_ledger_ac,$unlo_inputs,$customer);
                // }

                //Log::info($customer_unlocated_ledger_ac);
                $debited_ac = $ledger_account_received_payment->code;
                $credited_ac = $unearned_revenue_ledger_ac->code;
                $amount = $cash_paid_cons;
                $trans_name = $notes;
                $trans_type = $trans_type_customer_payment;
                $transaction_id = $this->helper->getToken(10);
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $support = $double_entry->supports()->save($ledger_support_document);
                $invoice_amount = $invoice_amount - $cash_paid_cons;
                //Log::info("Performed Excess Entry");
            }

            //
            if($customer_invoice_payment){
                //Invoice Amount Ledger Entries
                $amount = $invoice_amount;
                $debited_ac = $ledger_account_received_payment->code;
                $credited_ac = $customer_ledger_ac->code;
                $trans_name = $notes;
                $trans_type = $trans_type_customer_payment;
                $transaction_id = $this->helper->getToken(10);
                $double_entry = $this->accountingVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $support = $double_entry->supports()->save($ledger_support_document);
                $http_resp['description'] = "Customer Receipt successful created!";
            }
            

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);

    }

}

<?php

namespace App\Supplier\Http\Controllers\Api\Payments;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier\Models\SupplierPayment;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Supplier\Models\Supplier;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Repositories\SupplierRepository;
use App\Accounting\Repositories\AccountingRepository;
use App\Models\NotificationCenter\MailBox;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;

class PaymentController extends Controller
{
    protected $supplierPayment;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $bills;
    protected $suppliers;
    protected $bankAccounts;
    protected $chartAccounts;
    protected $company_users;
    protected $bankTransactions;
    protected $accountDoubleEntries;

    public function __construct( SupplierPayment $supplierPayment ){
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierPayment = new SupplierRepository($supplierPayment);
        $this->bills = new SupplierRepository( new SupplierBill() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        $this->chartAccounts = new FinanceRepository( new AccountChartAccount() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->bankTransactions = new FinanceRepository( new BankTransaction() );
        $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $user = $request->user();
        $results = array();
        $company = $this->practices->find($user->company_id);
        $payments = $company->supplier_payments()->orderByDesc('created_at')->paginate(10);
        foreach($payments as $payment){
            array_push($results,$this->supplierPayment->transform_payment($payment));
        }
        $paged_data = $this->helper->paginator($payments);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //
        $pay_mode_cheque = AccountsCoa::PAY_METHOD_CHEQUE;
        $pay_mode_cash = AccountsCoa::PAY_METHOD_CASH;
        $http_resp = $this->http_response['200'];
        $rule = [
            'payment_date'=>'required',
            'payment'=>'required',
            'notes'=>'required',
            'supplier_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //
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
        //
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{
            //Transactions begins here
            $user = $request->user();
            $company = $this->practices->find($user->company_id);
            $supplier = $this->suppliers->findByUuid($request->supplier_id);
            $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
            $company_user = $this->company_users->findByUserAndCompany($user,$company);
            $finance_settings = $company->practice_finance_settings()->get()->first();
            $cash_paid = $request->payment['cash_paid'];
            $bill = null;
            $notes = $request->notes;
            $as_at = $this->helper->format_lunox_date($request->payment_date);
            $payment_method = $payment_mode;
            $pay_reference = null;
            $currency = $request->currency;
            $account_type_supplier = AccountsCoa::AC_TYPE_SUPPLIER;
            $trans_type_supplier_payment = AccountsCoa::TRANS_TYPE_SUPPLIER_PAYMENT;

            $ledger_account_paid_bill = null;
            if($finance_settings){
                $payment_prefix = "RCP";
                $bill_prefix = $finance_settings->bill_prefix;
            }else{
                $payment_prefix = "RCP";
                $bill_prefix = "BL";
            }

            //Get supplier bill paid for if bill number is provided
            if($request->bill_number != ''){
                $bill = $this->bills->findByTransNumber($request->bill_number);
            }
            /*
                Get Ledger account used to pay this bill depending on payment mode:
                1. Mode "Cheque" Bank Ledger Account was used
                2. Mode "Cash" Chart of account was used to pay for this bill
            */
            $bank_account = null;
            if( $payment_mode == $pay_mode_cheque ){
                $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
                $bank_ledger_account = $bank_account->ledger_accounts()->get()->first();
                $ledger_account_paid_bill = $bank_ledger_account;
                $pay_reference = $request->payment['cheque_number'];
            }else{
                $ledger_account = $this->chartAccounts->findByUuid($request->payment['ledger_account_id']);
                $ledger_account_paid_bill = $ledger_account;
                $pay_reference = $request->payment['reference_number'];
            }

            //Record this payment into Payments table as below
            $pay_inputs['amount'] = $cash_paid;
            //$pay_inputs['bill_id'] = $bill->id;
            $pay_inputs['supplier_id'] = $supplier->id;
            $pay_inputs['payment_date'] = $as_at;
            $pay_inputs['ledger_account_id'] = $ledger_account_paid_bill->id;
            $pay_inputs['payment_method'] = $payment_method;
            $pay_inputs['notes'] = $notes;
            $pay_inputs['reference_number'] = $pay_reference;
            $pay_inputs['trans_number'] = $payment_prefix;
            $new_supplier_payment = $company->supplier_payments()->create($pay_inputs);
            $new_supplier_payment->trans_number = $this->helper->create_transaction_number($payment_prefix,$new_supplier_payment->id);
            $new_supplier_payment->save();

            /*
                Ledger Double Entries begins:
                1. If "bill_number" is provided, no taxation and Discount Entries to be performed since they were entered during raising of bill
                2. If "bill_number" is not provided, taxation and Discount Entries can be performed.
            */
            if($request->has('paid_bills')){
                $paid_bills = $request->paid_bills;
                $cash_paid_cons = $cash_paid;
                for( $i=0; $i<sizeof($paid_bills); $i++){
                    $bill = $this->bills->findByUuid($paid_bills[$i]);
                    if( $cash_paid_cons > 0){
                        $net_total = $bill->net_total;
                        $total_payment = $bill->paymentItems()->sum('paid_amount'); //This what is so far paid on this bill
                        $status_inputs['notes'] = "Payment of ".$currency." ".$cash_paid." made";
                        $balance_to_pay = $net_total - $total_payment;

                        // if( ($cash_paid==0) || (($cash_paid+$total_payment) > $net_total) ){
                        //     $http_resp = $this->http_response['422'];
                        //     DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                        //     DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                        //     DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                        //     $http_resp['errors'] = ['Check amount paid!'];
                        //     return response()->json($http_resp,422);
                        // }elseif( ($cash_paid+$total_payment) < $net_total ){
                        //     $status_inputs['status'] = Product::STATUS_PARTIAL_PAID;
                        // }else{
                        //     $status_inputs['status'] = Product::STATUS_PAID;
                        // }

                        if( $cash_paid_cons >= $balance_to_pay  ){
                            $status_inputs['status'] = Product::STATUS_PAID;
                            // Log::info($cash_paid_cons);
                            // Log::info($balance_to_pay);
                            // Log::info(Product::STATUS_PAID);
                            $cash_paid_cons -= $balance_to_pay;
                            $paid_cons = $balance_to_pay;
                            // Log::info($cash_paid_cons);
                            // Log::info('---------------------------');
                        }else{
                            $status_inputs['status'] = Product::STATUS_PARTIAL_PAID;
                            // Log::info($cash_paid_cons);
                            // Log::info($balance_to_pay);
                            // Log::info(Product::STATUS_PARTIAL_PAID);
                            $paid_cons = $cash_paid_cons;
                            $cash_paid_cons = 0;
                            // Log::info($cash_paid_cons);
                            // Log::info('---------------------------');
                        }
                        $bill_status = $company_user->bill_status()->create($status_inputs);
                        $bill_status = $bill->bill_status()->save($bill_status);
                        $bill->status = $status_inputs['status'];
                        $bill->save();
                        //Create Payment Item as below
                        $item_inputs['bill_id'] = $bill->id;
                        $item_inputs['supplier_payment_id'] = $new_supplier_payment->id;
                        $item_inputs['paid_amount'] = $paid_cons;
                        $bill_payment = $bill->paymentItems()->create($item_inputs);
                    }
                }
            }

            //Bank was used to for this payment so record bank transaction
            if($bank_account){
                $spent = $cash_paid;
                $bank_reference = $pay_reference;
                $discount = 0;
                //Bank Transaction is Recorded
                /*
                    Any Bank Transaction Recorded to the system, 
                    "reference_number" must be an issued reference number 
                    from the bank institution, this is important when it comes to bank reconciliation
                */
                $transactions['bank_account_id'] = $bank_account->id;
                $transactions['transaction_date'] = $as_at;
                $transactions['spent'] = $spent;
                $transactions['type'] = $account_type_supplier;
                $transactions['name'] = $trans_type_supplier_payment;
                $transactions['payee'] = $company->name;
                $transactions['description'] = $notes;
                $transactions['reference'] = $bank_reference;
                $transactions['discount'] = $discount;
                $transactions['comment'] = $notes;
                $bank_transaction = $new_supplier_payment->bank_transactions()->create($transactions);//Create and Link this transaction to Supplier Payments
                $bank_transaction = $company->bank_transactions()->save($bank_transaction);//Link transaction to a company
                //$support = $double_entry->supports()->save($ledger_support_document);
                //$support_doc = $bank_transaction->double_entry_support_document()->save($new_bill);
                //Attach this bank transaction to an Open Bank Reconciliation as Below:
                //1. Get available Reconciliation by line below
                $bank_account_reconciliation = $this->bankTransactions->getOrCreateBankReconciliation($bank_account,$as_at,null);
                $this->bankTransactions->reconcile_bank_transaction($company_user,$bank_account_reconciliation,$bank_transaction,$bank_account,null,AccountsCoa::RECONCILIATION_NOT_TICKED);
            }
            //Journal Entries
            $debited_ac = $supplier_ledger_ac->code;
            $credited_ac = $ledger_account_paid_bill->code;
            $amount = $cash_paid;
            $trans_name = $notes;
            $trans_type = $trans_type_supplier_payment;
            $transaction_id = $this->helper->getToken(10);
            $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
            $ledger_support_document = $new_supplier_payment->double_entry_support_document()->create(['trans_type'=>$trans_type_supplier_payment]);
            $support = $double_entry->supports()->save($ledger_support_document);
            $http_resp['description'] = "Payment successful created!";

        }catch(Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        $action = null;
        if($request->has('action')){
            $action = $request->action;
        }else{

        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            //$practiceParent = $this->practices->findParent($company);
            $company_user = $this->company_users->findByUserAndCompany($user,$company);
            $payment = $this->supplierPayment->findByUuid($uuid);

            if($action){
                $subj = MailBox::SPAYMENT_SUBJECT;
                switch ($action) {
                    case Product::ACTIONS_SEND_MAIL:
                        $send_to = $request->send_to;
                        $status['status'] = Product::STATUS_OPEN;
                        $status['type'] = "action";
                        $status['notes'] = $subj." emailed to ".$send_to;
                        //Schedule this Email to be Send
                        $mailing_address['subject'] = $request->subject;
                        $mailing_address['subject_type'] = $subj;
                        $mailing_address['msg'] = $request->content;
                        $mailing_address['email'] = $send_to;
                        //$mailing_address['cc'] = $request->cc;
                        $mailbox = $company->product_email_notifications()->create($mailing_address);
                        //$mailbox = $company->product_email_notifications()->save($mailbox);
                        $attachment = $mailbox->attatchments()->create(['attachment_type'=>$subj]);
                        $attachment = $payment->mails_attachments()->save($attachment);
                        //----
                        $pay_status = $company_user->payment_status()->create($status);
                        $pay_status = $payment->payment_status()->save($pay_status);
                        $http_resp['description'] = "Email successful sent!";
                        break;
                    case Product::ACTIONS_PRINT:
                        $status['status'] = Product::STATUS_PRINTED;
                        $status['notes'] = $subj." printed";
                        $status['type'] = "action";
                        $payment_status = $company_user->payment_status()->create($status);
                        $payment_status = $payment->payment_status()->save($payment_status);
                        break;
                    case Product::ACTIONS_COMMENT:
                        $status['status'] = Product::ACTIONS_COMMENT;
                        $status['notes'] = $request->comment;
                        $status['type'] = "action";
                        $payment_status = $company_user->payment_status()->create($status);
                        $payment_status = $payment->payment_status()->save($payment_status);
                        $http_resp['description'] = "Comment successful added!";
                        break;
                    default:
                        break;
                }
            }

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            // DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            // DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        // DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        // DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show($uuid){

        $http_resp = $this->http_response['200'];
        $payment = $this->supplierPayment->findByUuid($uuid);
        //$bill = $payment->supplierBills()->get()->first();
        $journals = array();
        $attachments = array();
        $attachmens = $payment->assets()->get();
        foreach($attachmens as $attachmen){
            array_push($attachments,$this->supplierPayment->transform_assets($attachmen));
        }

        // if($bill){
        //     $support_document = $bill->double_entry_support_document()->get()->first();
        //     $journal_entries = $support_document->accounts_vouchers()->get();
        //     foreach($journal_entries as $journal_entry){
        //         array_push($journals,$this->accountDoubleEntries->create_journal_report($journal_entry));
        //     }
        // }
        $support_document = $payment->double_entry_support_document()->get()->first();
        $journal_entries = $support_document->accounts_vouchers()->get();
        foreach($journal_entries as $journal_entry){
            array_push($journals,$this->accountDoubleEntries->create_journal_report($journal_entry));
        }

        $payment_data = $this->supplierPayment->transform_payment($payment);
        $payment_data['journals'] = $journals;
        $payment_data['attachments'] = $attachments;
        $http_resp['results'] = $payment_data;
        return response()->json($http_resp);

    }

}

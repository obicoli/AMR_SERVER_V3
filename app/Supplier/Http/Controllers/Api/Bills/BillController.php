<?php

namespace App\Supplier\Http\Controllers\Api\Bills;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\NotificationCenter\MailBox;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeTaxation;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\PurchaseOrder;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductTaxation;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Models\SupplierPayment;
use App\Supplier\Models\SupplierTerms;
use Exception;

class BillController extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $supplierBills;
    protected $purchaseOrders;
    protected $productItems;
    protected $suppliers;
    protected $customers;
    protected $company_users;
    protected $product_pricing;
    protected $productTaxations;
    protected $paymentTerms;
    protected $chartOfAccounts;
    protected $bankAccounts;
    protected $companyTaxations;
    protected $bankTransactions;
    protected $supplierPayments;
    protected $accountDoubleEntries;

    protected $status_overdue;
    protected $status_paid;
    protected $status_draft;
    protected $status_open;
    protected $status_partial_paid;
    protected $status_partial_unpaid;

    public function __construct( SupplierBill $supplierBill )
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->supplierBills = new SupplierRepository( $supplierBill );
        $this->productItems = new ProductReposity( new ProductItem() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->purchaseOrders = new SupplierRepository( new PurchaseOrder() );
        $this->paymentTerms = new SupplierRepository(new SupplierTerms());
        $this->chartOfAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank());
        $this->companyTaxations = new PracticeRepository( new PracticeTaxation() );
        $this->bankTransactions = new FinanceRepository( new BankTransaction() );
        $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
        $this->supplierPayments = new SupplierRepository( new SupplierPayment() );
        //
        $this->status_overdue = Product::STATUS_OVERDUE;
        $this->status_open = Product::STATUS_OPEN;
        $this->status_partial_paid = Product::STATUS_PARTIAL_PAID;
        $this->status_partial_unpaid = Product::STATUS_UNPAID;
        $this->status_paid = Product::STATUS_PAID;
    }

    public function index(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        if($request->has('filter_by')){
            switch ($request->filter_by) {
                case $this->status_overdue:
                    $today_is = date('Y-m-d H:i:s');
                    $bill_lists = $company->supplier_bills()
                    ->where('bill_due_date','<',$today_is)
                    ->where('status',$this->status_open)
                    ->orWhere('status',$this->status_partial_paid)
                    ->orderByDesc('created_at')
                    ->paginate(10);
                    break;
                case $this->status_partial_unpaid:
                    $bill_lists = $company->supplier_bills()
                    ->where('status','!=',$this->status_paid)
                    ->orderByDesc('created_at')
                    ->paginate(10);
                    break;
                default:
                    $bill_lists = $company->supplier_bills()
                    ->where('status',$request->filter_by)
                    ->orderByDesc('created_at')
                    ->paginate(10);
                    break;
            }
        }else{
            $bill_lists = $company->supplier_bills()->orderByDesc('created_at')->paginate(10);
        }
        
        $results = array();
        foreach($bill_lists as $bill_list){
            array_push( $results,$this->supplierBills->transform_bill($bill_list) );
        }
        $paged_data = $this->helper->paginator($bill_lists);
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        //Log::info($request);

        $cash_basis_bill = AccountsCoa::BILL_TYPE_CASH;
        $credit_basis_bill = AccountsCoa::BILL_TYPE_CREDIT;
        $discount_received_allowed_ledger_code = AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE;
        $account_type_supplier = AccountsCoa::AC_TYPE_SUPPLIER;
        $partial_settlement = AccountsCoa::PAY_SETTLEMENT_PARTIAL;
        $full_settlement = AccountsCoa::PAY_SETTLEMENT_FULL;
        $payment_method_cheque = AccountsCoa::PAY_METHOD_CHEQUE;
        $payment_method_cash = AccountsCoa::PAY_METHOD_CASH;
        $transaction_status_partial_paid = Product::STATUS_PARTIAL_PAID;
        $transaction_status_paid = Product::STATUS_PAID;
        $transaction_status_draft = Product::STATUS_DRAFT;
        $transaction_status_open = Product::STATUS_OPEN;
        $trans_type_supplier_bill = AccountsCoa::TRANS_TYPE_SUPPLIER_BILL;
        $trans_type_supplier_payment = AccountsCoa::TRANS_TYPE_SUPPLIER_PAYMENT;
        $trans_type_payment_receipt = AccountsCoa::TRANS_TYPE_PAYMENT_RECEIPT;
        /*
            When a business purchases goods on credit from a supplier the terms will stipulate
            the date on which the amount outstanding is to be paid. In addition the terms 
            will often allow a purchase discount to be taken if the 
            invoice is settled at an earlier date.

            VAT Journal Entries

            When Goods are bought and you have to pay both purchase value and VAT input or pay both, following entry will be passed:
                Purchase A/C .Dr (Value of purchase)
                VAT A/C .Dr (VAT on purchase)
                To Cash/Bank/Creditor A/C (Value of purchase + VAT input
            
            When Goods are sold and you have to receive both sales value and VAT Output or both, following journal entries will be passed:
                Cash/Bank/Name of Customer s A/C Dr.(Value of purchase+VAT)
                To Sales A/C (Value of Sales)
                To VAT Output A/C (VAT on Sale)
            When we pay the NET VAT(Payable), following journal entry will be passed:
                Net VAT Payable A/C .Dr (Excess of VAT output over VA
                To Bank A/C
        */
        $http_resp = $this->http_response['200'];
        $rule = [
            'bill_date'=>'required',
            'bill_due_date'=>'required',
            'supplier_id'=>'required',
            'notes'=>'required',
            'taxation_option'=>'required',
            'bill_type'=>'required',
            'items'=>'required',
            'net_total'=>'required',
            'grand_total'=>'required',
            'total_tax'=>'required',
            'total_discount'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }


        if( $request->bill_type == Product::DOC_CASH_BILL ){
            $rule = [
                'cash_paid'=>'required',
                'cash_balance'=>'required',
                'payment_method'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

        if( $request->payment['payment_method'] == $payment_method_cheque ){
            $rule = [
                'bank_account_id'=>'required',
                'cheque_number'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

        if( $request->payment['payment_method'] == $payment_method_cash ){
            $rule = [
                'ledger_account_id'=>'required',
            ];
            $validation = Validator::make($request->payment,$rule,$this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first();
            $company_user = $this->company_users->findByUserAndCompany($user,$company); //Get current user
            $payment_term = $this->paymentTerms->findByUuid($request->payment_term_id);
            //Inventory account which goods/items were purchased for
            $inventory_account = $this->chartOfAccounts->findByUuid($request->ledger_account_id);
            //Get supplier and supplier Ledger Account
            $supplier = $this->suppliers->findByUuid($request->supplier_id);
            $supplier_account = $supplier->account_holders()->get()->first();
            $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
            $ledger_support_document = null;
            $bank_reference = $request->payment['cheque_number'];//This is the CHEQUE Number()
            $action_taken = $request->action_taken;
            $action_type_draft = Product::ACTIONS_SAVE_DRAFT;
            $action_type_open = Product::ACTIONS_SAVE_OPEN;

            //Create new bill
            $inputs = $request->all();
            $inputs['bill_date'] = $this->helper->format_lunox_date($inputs['bill_date']);
            $inputs['bill_due_date'] = $this->helper->format_lunox_date($inputs['bill_due_date']);

            $as_at = $this->helper->format_lunox_date($inputs['bill_date']);
            $notes = $request->notes;
            $discount = $request->total_discount;
            $grand_total = $request->grand_total;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $bank_account = null;
            $bill_type = $request->bill_type;
            $currency = $request->currency;

            if($finance_settings){
                $payment_prefix = "PAY";
                $bill_prefix = $finance_settings->bill_prefix;
            }else{
                $payment_prefix = "PAY";
                $bill_prefix = "BL";
            }


            //$grand_total = $request->grand_total;
            $cash_paid = $request->payment['cash_paid'];
            $cash_balance = $request->payment['cash_balance'];
            $payment_method = $request->payment['payment_method'];

            $inputs['supplier_id'] = $supplier->id;
            if($payment_term){ $inputs['payment_term_id'] = $payment_term->id;}else{ $inputs['payment_term_id'] = $supplier->payment_term_id;}
            //Account used to pay this bill
            $ledger_ac_paid_this_bill = null;
            if( $request->payment['payment_method']==$payment_method_cheque ){
                $bank_account = $this->bankAccounts->findByUuid($request->payment['bank_account_id']);
                $ledger_ac_paid_this_bill = $bank_account->ledger_accounts()->get()->first();
            }else{
                $ledger_ac_paid_this_bill = $this->chartOfAccounts->findByUuid($request->payment['ledger_account_id']);
            }

            //Create Bill
            $new_bill = $this->supplierBills->create($inputs);
            $ledger_support_document = $new_bill->double_entry_support_document()->create(['trans_type'=>$trans_type_supplier_bill]);
            // if($finance_settings){ $bill_prefix = $finance_settings->bill_prefix; }else{ $bill_prefix = "BIL"; }
            $new_bill->trans_number = $this->helper->create_transaction_number($bill_prefix,$new_bill->id);
            $new_bill = $company->supplier_bills()->save($new_bill);
            /*
                Cash Purchase Transaction Paid by Cheque, discount allowed, tax applied

                1. Supplier Ledger AC(Payable) v/s Account used to pay "ledger_ac_paid_this_bill"(Assets)
                2. Supplier Ledger(Payable) AC v/s Discount Ledger AC(Income)
                3. Supplier Ledger(Payable) AC v/s Sales Tax(Liability)
                4. Record Bank Transaction if Cheque was use
                5. Record into supplier Payments
            */

            //1. Get all taxation collected on purchases in different tax VATs
            $tax_registrations = $practiceParent->product_taxations()
                ->where('collected_on_purchase',true)
                ->get();
            $tax_id_array = array();
            $tax_value_array = array();

            //Process items
            $items = $request->items;
            for ($j=0; $j < sizeof($items); $j++) {
                //Process Items Here
                $current_item = $items[$j];
                $product_item = $this->productItems->findByUuid($items[$j]['id']);
                $price = $this->product_pricing->createPrice($product_item->id,
                $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
                $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
                $item_inputs = [
                    'supplier_bill_id'=>$new_bill->id,
                    'qty'=>$items[$j]['qty'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $bill_item = $new_bill->items()->create($item_inputs);
                //
                $item_taxes = $current_item['applied_tax_rates'];
                for ($i=0; $i < sizeof($item_taxes); $i++) { 
                    //get Tax from DB
                    $taxe = $this->productTaxations->findByUuid($item_taxes[$i]);
                    $tax_inputs = [
                        'sales_rate'=>$taxe->sales_rate,
                        'purchase_rate'=>$taxe->purchase_rate,
                        'collected_on_sales'=>$taxe->collected_on_sales,
                        'collected_on_purchase'=>$taxe->collected_on_purchase,
                        'product_taxation_id'=>$taxe->id,
                        'bill_item_id'=>$bill_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('bill_item_taxations')->insert($tax_inputs);
                }
                //Input-Tax on different "VAT type" is totalized(Collected) as below
                if( sizeof($items[$j]['applied_tax_rates']) ){
                    $applied_tax_id = $items[$j]['applied_tax_rates'][0];
                    $line_tax = $items[$j]['line_taxation'];
                    if( !in_array($applied_tax_id,$tax_id_array) ){
                        array_push($tax_id_array,$applied_tax_id);
                        array_push($tax_value_array,$line_tax);
                    }else{
                        $key_is = array_search($applied_tax_id, $tax_id_array);
                        $tax_value_array[$key_is] = $tax_value_array[$key_is] + $line_tax;
                    }
                }
            }

            //
            $trans_type = AccountsCoa::TRANS_TYPE_SUPPLIER_BILL;
            //$trans_name = $notes;
            //$as_at = $request->bill_date;
            //$reference_number = $new_bill->trans_number;
            //$account_holder_number = $supplier_account->account_number;

            //VAT Journal Entries
            //Accounting: tax collected
            if( sizeof($tax_id_array) ){
                if( $bill_type == $cash_basis_bill ){//Cash Basis
                    $credited_ac = $ledger_ac_paid_this_bill->code;
                }else{//Credit Basis
                    $credited_ac = $supplier_ledger_ac->code;
                }
                //Collect Taxa
                for ($tz=0; $tz < sizeof($tax_id_array); $tz++) {
                    //GetCompany Tax record record from Register(at Main Branch)
                    $product_taxation = $this->productTaxations->findByUuid($tax_id_array[$tz]);
                    //Get Branch Taxation Record
                    $practice_taxation = $product_taxation->practice_taxation()
                        ->where('practice_id',$company->id)
                        ->get()
                        ->first();
                    $company_tax_ledger_ac = $practice_taxation->ledger_accounts()->get()->first();
                    $debited_ac = $company_tax_ledger_ac->code;
                    $amount = $tax_value_array[$tz];
                    $trans_name = "Input tax ".$product_taxation->name;
                    $transaction_id = $this->helper->getToken(10,'BL');
                    $tax_double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                    $tax_support = $tax_double_entry->supports()->save($ledger_support_document);
                    //$support_doc2 = $new_bill->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number,'voucher_id'=>$double_entry2->id]);
                    //$support_doc2 = $new_bill->double_entry_support_document()->save($support_doc2);
                }
            }

            //Accounting: Discount we received from purchase
            if($discount > 0){
                //$trans_type = AccountsCoa::TRANS_TYPE_DISCOUNT_RECEIVED;
                //$trans_name = $comment;
                $trans_name = "Discount received";
                $amount = $discount;
                $transaction_id = $this->helper->getToken(10,'DISC');
                $company_discount_received_account = $company->chart_of_accounts()->where('default_code',$discount_received_allowed_ledger_code)->get()->first();
                $debited_ac = $supplier_ledger_ac->code;
                $credited_ac = $company_discount_received_account->code;
                $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $support = $double_entry->supports()->save($ledger_support_document);
                //$support_doc2 = $new_bill->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number,'voucher_id'=>$double_entry2->id]);
            }

            //Accounting: Purchase Inventory
            //$amount = $total_bill - $request->total_discount; //This is the amount after discount is removed
            //$amount = $amount - $request->total_tax;
            //$spent = $request->total_bill - $request->total_discount;
            $amount = $grand_total - $discount - $total_tax;
            $transaction_id = $this->helper->getToken(10,'SPAY');
            $debited_ac = $inventory_account->code;
            $trans_name = $notes;
            if( $bill_type == $cash_basis_bill ){//Cash Basis
                $credited_ac = $ledger_ac_paid_this_bill->code;
            }else{//Credit Basis
                $credited_ac = $supplier_ledger_ac->code;
            }
            //$credited_ac = $ledger_ac_paid_this_bill->code;
            $trans_type = $trans_type_supplier_payment;
            $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
            $support = $double_entry->supports()->save($ledger_support_document);

            //$support_doc2 = $new_bill->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_holder_number,'reference_number'=>$reference_number,'voucher_id'=>$double_entr->id]);

            //Here you record payment if this bill is a "Cash Basis"
            $pay_inputs = [];
            if( $bill_type === $cash_basis_bill ){
                //Check if fully settled
                if( $net_total == $cash_paid ){ //"Total Bill" was fully paid
                    $pay_inputs['status'] = $transaction_status_paid;
                    $pay_inputs['settlement_type'] = $full_settlement;
                }elseif( ($cash_paid > 0) && ($cash_paid<$net_total) ){ //"Bill" was partial paid
                    $pay_inputs['status'] = $transaction_status_partial_paid;
                    $pay_inputs['settlement_type'] = $partial_settlement;
                }else{
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = ['Cash amount paid is required!'];
                    DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
                    DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                    DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                    return response()->json($http_resp,422);
                }
                //
                if($bank_reference && $payment_method == $payment_method_cheque){
                    $pay_reference = $bank_reference;
                }else{
                    $pay_reference = $new_bill->trans_number;
                }
                //Record this payment into Payments table as below
                $pay_inputs['amount'] = $cash_paid;
                $pay_inputs['bill_id'] = $new_bill->id;
                $pay_inputs['supplier_id'] = $supplier->id;
                $pay_inputs['payment_date'] = $as_at;
                $pay_inputs['ledger_account_id'] = $ledger_ac_paid_this_bill->id;
                $pay_inputs['payment_method'] = $payment_method;
                $pay_inputs['notes'] = $notes;
                $pay_inputs['reference_number'] = $pay_reference;
                $pay_inputs['trans_number'] = $payment_prefix;
                $new_supplier_payment = $company->supplier_payments()->create($pay_inputs);
                $new_supplier_payment->trans_number = $this->helper->create_transaction_number($payment_prefix,$new_supplier_payment->id);
                $new_supplier_payment->save();
                //Here also record status of the bill
                //Create the status  and attach it the user responsible
                //Then attach it to estimate
                $pay_inputs['notes'] = "Bill created for ".$currency." ".number_format($net_total,2);
                //Record Bank Transaction if Cheque was Used to pay this bill and attach to above "new_supplier_payment" as below
                if( $bill_type==$cash_basis_bill && $payment_method == $payment_method_cheque){
                    $spent = $grand_total - $discount;
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
                    //Log::info($bank_account);
                    $bank_account_reconciliation = $this->bankTransactions->getOrCreateBankReconciliation($bank_account,$as_at,null);
                    $this->bankTransactions->reconcile_bank_transaction($company_user,$bank_account_reconciliation,$bank_transaction,$bank_account,null,AccountsCoa::RECONCILIATION_NOT_TICKED);
                }
            }else{
                $pay_inputs['notes'] = "Bill created for ".$currency." ".number_format($net_total,2);
                switch ( $action_taken ) {
                    case $action_type_draft:
                        $pay_inputs['status'] = $transaction_status_draft;
                        break;
                    default:
                        $pay_inputs['status'] = $transaction_status_open;
                        break;
                }
            }
            $bill_status = $company_user->bill_status()->create($pay_inputs);
            $bill_status = $new_bill->bill_status()->save($bill_status);
            $new_bill->status = $pay_inputs['status'];
            $new_bill->save();

        }catch( \Exception $e ){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        $action = null;
        if($request->has('action')){
            $action = $request->action;
        }else{
            $rule = [
                'bill_date'=>'required',
                'bill_due_date'=>'required',
                'supplier_id'=>'required',
                'notes'=>'required',
                'taxation_option'=>'required',
                'bill_type'=>'required',
                'items'=>'required',
                'net_total'=>'required',
                'grand_total'=>'required',
                'total_tax'=>'required',
                'total_discount'=>'required',
            ];
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $company_user = $this->company_users->findByUserAndCompany($user,$company);
            //$purchase_order = $this->purchaseOrders->findByUuid($uuid);
            $bill = $this->supplierBills->findByUuid($uuid);

            if($action){

                $subj = MailBox::BILL_SUBJECT;
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
                        $attachment = $mailbox->attatchments()->create(['attachment_type'=>MailBox::BILL_SUBJECT]);
                        $attachment = $bill->mails_attachments()->save($attachment);
                        //----
                        $po_status = $company_user->bill_status()->create($status);
                        $po_status = $bill->bill_status()->save($po_status);
                        $http_resp['description'] = "Email successful sent!";
                        break;
                    case Product::ACTIONS_PRINT:
                        $status['status'] = Product::STATUS_PRINTED;
                        $status['notes'] = "Bill printed";
                        $status['type'] = "action";
                        $bil_status = $company_user->bill_status()->create($status);
                        $bil_status = $bill->bill_status()->save($bil_status);
                        break;
                    case Product::ACTIONS_COMMENT:
                        $status['status'] = Product::ACTIONS_COMMENT;
                        $status['notes'] = $request->comment;
                        $status['type'] = "action";
                        $bill_status = $company_user->bill_status()->create($status);
                        $bill_status = $bill->bill_status()->save($bill_status);
                        $http_resp['description'] = "Comment successful added!";
                        break;
                    default: //Change status
                        $status['status'] = $request->status;
                        $status['notes'] = $subj." changed status";
                        $bill_status = $company_user->bill_status()->create($status);
                        $bill_status = $bill->bill_status()->save($bill_status);
                        $bill->status = $request->status;
                        $bill->save();
                        $http_resp['description'] = "Status successful changed!";
                        break;
                }
            }

        }catch(Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function show($uuid){
        
        $http_resp = $this->http_response['200'];
        $bill = $this->supplierBills->findByUuid($uuid);

        $payments = array();
        $payments_made = $bill->payments()->get();
        foreach($payments_made as $payment_made){
            array_push($payments, $this->supplierPayments->transform_payment($payment_made));
        }

        $attachments = array();
        $attachmens = $bill->assets()->get();
        foreach($attachmens as $attachmen){
            array_push($attachments,$this->supplierBills->transform_assets($attachmen));
        }

        $bill_trails = $bill->bill_status()->get();
        $bill_audit_trails = array();
        foreach ($bill_trails as $bill_trail) {
            $temp_sta['id'] = $bill_trail->uuid;
            $temp_sta['status'] = $bill_trail->status;
            $temp_sta['type'] = $bill_trail->type;
            $temp_sta['notes'] = $bill_trail->notes;
            $temp_sta['date'] = date('Y-m-d H:i:s',\strtotime($bill_trail->created_at));
            $practice_user = $bill_trail->responsible()->get()->first();
            $temp_sta['signatory'] = $this->company_users->transform_user($practice_user);
            array_push($bill_audit_trails,$temp_sta);
        }

        $journals = array();
        $support_document = $bill->double_entry_support_document()->get()->first();
        $journal_entries = $support_document->accounts_vouchers()->get();
        foreach($journal_entries as $journal_entry){
            array_push($journals,$this->accountDoubleEntries->create_journal_report($journal_entry));
        }

        $bill_data = $this->suppliers->transform_bill($bill);
        $bill_data['audit_trails'] = $bill_audit_trails;
        $bill_data['attachments'] = $attachments;
        $bill_data['payments'] = $payments;
        $bill_data['journals'] = $journals;
        $bill_data['items'] = $this->suppliers->transform_items($bill,$bill_data);
        $http_resp['results'] = $bill_data;
        return response()->json($http_resp);
    }

}

<?php

namespace App\Supplier\Http\Controllers\Api\Credits;

use App\Supplier\Models\SupplierCredit;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\NotificationCenter\MailBox;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Product;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Product\ProductTaxation;
use App\Supplier\Models\SupplierBill;

class VendorCreditController extends Controller
{
    /*
        -Credits you receive from your vendor, and it is treated as an equivalent of physical cash that vendor owes you.
        -This helps you track money you're owed until it is either paid by the said vendor at a later date.
            i.e refunded, or subtracted from any future bill amount due from that vendor
        -The vendor issues you a credit via a credit note, then you record your credit into the system via this controller
    */
    protected $supplierCredit;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $supplierBills;
    protected $productItems;
    protected $suppliers;
    protected $company_users;
    protected $product_pricing;
    protected $productTaxations;
    protected $chartOfAccounts;
    protected $companyTaxations;
    protected $accountDoubleEntries;

    public function __construct(SupplierCredit $supplierCredit)
    {
        $this->supplierCredit = new SupplierRepository($supplierCredit);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->productItems = new ProductReposity( new ProductItem() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        //$this->customers = new CustomerRepository( new Customer() );
        $this->company_users = new PracticeRepository(new PracticeUser());
        $this->product_pricing = new ProductReposity(new ProductPriceRecord());
        $this->productTaxations = new ProductReposity( new ProductTaxation() );
        $this->supplierBills = new SupplierRepository( new SupplierBill() );
        $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
        $this->chartOfAccounts = new AccountingRepository( new AccountChartAccount() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $supplier_credits = $company->supplier_credits()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($supplier_credits);
        foreach($supplier_credits as $supplier_credit){
            array_push($results, $this->supplierCredit->transform_supplier_credit($supplier_credit));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'supplier_id'=>'required',
            'notes'=>'required',
            'items'=>'required',
            'notes'=>'required',
            'credit_date'=>'required',
            'taxation_option'=>'required',
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

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($request->user()->company_id);
            $practiceParent = $this->practices->findParent($company);
            $finance_settings = $company->practice_finance_settings()->get()->first();
            $company_user = $this->company_users->findByUserAndCompany($user,$company); //Get current user
            $supplier = $this->suppliers->findByUuid($request->supplier_id);
            $supplier_ledger_ac = $supplier->ledger_accounts()->get()->first();
            $inventory_ac = null;
            $action_taken = $request->action_taken;
            $notes = $request->notes;
            $discount = $request->total_discount;
            $grand_total = $request->grand_total;
            $net_total = $request->net_total;
            $total_tax = $request->total_tax;
            $currency = $request->currency;
            $discount_received_ledger_code = AccountsCoa::AC_DISCOUNT_RECEIVED_REFUND_CODE;

            $save_draft = Product::ACTIONS_SAVE_DRAFT;
            $save_open = Product::ACTIONS_SAVE_OPEN;
            $save_send = Product::ACTIONS_SAVE_SEND;
            $save_new = Product::ACTIONS_SAVE_NEW;
            $save_close = Product::ACTIONS_SAVE_CLOSE;

            //Create new Return
            $inputs = $request->all();
            $as_at = $this->helper->format_lunox_date($inputs['credit_date']);
            $inputs['supplier_id'] = $supplier->id;
            $inputs['credit_date'] = $as_at;
            $new_credit = $company->supplier_credits()->create($inputs);
            $new_credit->trans_number = $this->helper->create_transaction_number('CRN',$new_credit->id);
            $new_credit->save();

            //Link Newly created Return to Bill if Bill Id is provided
            // if($request->has('bill_id')){
            //     $bill = $this->supplierBills->findByUuid($request->bill_id);
            //     $bill->supplierReturns()->save($new_return);
            //     $inventory_ac = $this->chartOfAccounts->find($bill->ledger_account_id);
            // }
            //Process Return Items
            $tax_id_array = array();
            $tax_value_array = array();
            $items = $request->items;
            for ($j=0; $j < sizeof($items); $j++) {
                //Process Items Here
                $current_item = $items[$j];
                $product_item = $this->productItems->findByUuid($items[$j]['id']);
                $price = $this->product_pricing->createPrice($product_item->id,
                $company->id,$items[$j]['price']['unit_cost'],$items[$j]['price']['unit_retail_price'],
                $items[$j]['price']['pack_cost'],$items[$j]['price']['pack_retail_price'],$request->user()->id);
                $item_inputs = [
                    'qty'=>$items[$j]['qty'],
                    'discount_rate'=>$items[$j]['discount_rate'],
                    'product_price_id'=>$price->id,
                    'product_item_id'=>$product_item->id,
                ];
                $credit_item = $new_credit->items()->create($item_inputs);
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
                        'supplier_credit_item_id'=>$credit_item->id,
                    ];
                    $item_taxation = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('supplier_credit_item_taxations')->insert($tax_inputs);
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

            $credit_inputs['status'] = Product::STATUS_DRAFT;
            $credit_inputs['supplier_credit_id'] = $new_credit->id;
            $credit_inputs['notes'] = "Supplier credit for ".$currency." ".number_format($net_total,2)." created";
            //This swtch block is to assit to determine if accounting transactions are suppossed to be saved or not
            //If user selected "Save as Draft" no accounting journal entries will take place
            //Else perform accounting journal entries
            switch ($action_taken) {
                case $save_new:
                case $save_open:
                case $save_send:
                case $save_close:
                    $trans_type = AccountsCoa::TRANS_TYPE_PURCHASE_RETURN;
                    $ledger_support_document = $new_credit->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                    //VAT Journal Entries
                    //Accounting: tax collected
                    if( sizeof($tax_id_array) ){
                        $debited_ac = $supplier_ledger_ac->code;
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
                            $credited_ac = $company_tax_ledger_ac->code;
                            $amount = $tax_value_array[$tz];
                            $trans_name = "Input tax ".$product_taxation->name;
                            $transaction_id = $this->helper->getToken(10,'RTN');
                            $tax_double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                            $tax_support = $tax_double_entry->supports()->save($ledger_support_document);
                        }
                    }
                    //Accounting: Discount
                    //-------------here discount comes
                    if($discount > 0){
                        $trans_name = $notes;
                        $amount = $discount;
                        $transaction_id = $this->helper->getToken(10,'DISC');
                        $company_discount_received_account = $company->chart_of_accounts()->where('default_code',$discount_received_ledger_code)->get()->first();
                        $debited_ac = $company_discount_received_account->code;
                        $credited_ac = $supplier_ledger_ac->code;
                        $double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                        $support = $double_entry->supports()->save($ledger_support_document);
                    }
                    //Accounting: Purchase(Inventory)
                    $amount = $grand_total - $discount - $total_tax;
                    $trans_name = $notes;
                    $transaction_id = $this->helper->getToken(10,'RTN');
                    $debited_ac = $supplier_ledger_ac->code;
                    $credited_ac = $inventory_ac->code;
                    $purchase_double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                    $purchase_double_entry->supports()->save($ledger_support_document);
                    $http_resp['description'] = "Supplier credit successful saved!";
                    break;
                default:
                    $http_resp['description'] = "Supplier credit successful saved!";
                    break;
            }

            $credit_status = $company_user->supplier_credit_status()->create($credit_inputs);
            $credit_status = $new_credit->trails()->save($credit_status);
            $new_credit->status = $credit_inputs['status'];
            $new_credit->save();

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
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
            $purchase_return = $this->supplierReturn->findByUuid($uuid);

            if($action){
                $subj = MailBox::PURCHASE_RETURN_SUBJECT;
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
                        $attachment = $purchase_return->mails_attachments()->save($attachment);
                        //----
                        $pay_status = $company_user->return_status()->create($status);
                        $pay_status = $purchase_return->trails()->save($pay_status);
                        $http_resp['description'] = "Email successful sent!";
                        break;
                    case Product::ACTIONS_PRINT:
                        $status['status'] = Product::STATUS_PRINTED;
                        $status['notes'] = $subj." printed";
                        $status['type'] = "action";
                        $payment_status = $company_user->return_status()->create($status);
                        $payment_status = $purchase_return->trails()->save($payment_status);
                        break;
                    case Product::ACTIONS_COMMENT:
                        $status['status'] = Product::ACTIONS_COMMENT;
                        $status['notes'] = $request->comment;
                        $status['type'] = "action";
                        $payment_status = $company_user->return_status()->create($status);
                        $payment_status = $purchase_return->trails()->save($payment_status);
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
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        $purchase_return = $this->supplierReturn->findByUuid($uuid);
        

        $journals = array();
        $support_document = $purchase_return->double_entry_support_document()->get()->first();
        $journal_entries = $support_document->accounts_vouchers()->get();
        foreach($journal_entries as $journal_entry){
            array_push($journals,$this->accountDoubleEntries->create_journal_report($journal_entry));
        }

        $attachments = array();
        $attachmens = $purchase_return->assets()->get();
        foreach($attachmens as $attachmen){
            array_push($attachments,$this->supplierReturn->transform_assets($attachmen));
        }

        $items = array();

        $return_purchase = $this->supplierReturn->transform_purchase_return($purchase_return);
        $return_purchase['journals'] = $journals;
        $return_purchase['attachments'] = $attachments;
        $return_purchase['items'] = $this->supplierReturn->transform_items($purchase_return,$return_purchase);
        $http_resp['results'] = $return_purchase;
        return response()->json($http_resp);
    }

}

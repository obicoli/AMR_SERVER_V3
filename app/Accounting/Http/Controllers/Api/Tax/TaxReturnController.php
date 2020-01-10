<?php

namespace App\Accounting\Http\Controllers\Api\Tax;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Tax\AccountsVatReturn;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaxReturnController extends Controller
{
    //
    protected $accountsVatReturn;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountsTaxations;
    protected $suppliers;
    protected $vatTypes;

    protected $type_supplier_bill;

    public function __construct(AccountsVatReturn $accountsVatReturn)
    {
        $this->accountsVatReturn = new AccountingRepository( $accountsVatReturn );
        $this->http_response = Config::get('response.http');
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountsTaxations = new AccountingRepository(new ProductTaxation());
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->vatTypes = new AccountingRepository( new ProductTaxation() );

        $this->type_supplier_bill = AccountsCoa::TRANS_TYPE_SUPPLIER_BILL;
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $user = $request->user();
        $results = array();
        $company = $this->practices->find($user->company_id);
        $tax_returns = $company->taxReturns()->orderByDesc('created_at')->paginate(10);
        $format = $company->date_format;
        $frequency = 1;

        $vat_period_summary['last_period_end_date'] = "";
        $vat_period_summary['last_submission_due_date'] = "";
        $vat_period_summary['next_period_end_date'] = "";
        $vat_period_summary['next_submission_due_date'] = "";
        $vat_period_summary['frequency'] = 1;

        $paged_data = $this->helper->paginator($tax_returns);

        $current_return = $company->taxReturns()->get()->first();
        if($current_return){
            $vat_period_summary['last_period_end_date'] = $this->helper->format_mysql_date($this->helper->get_next_date('-'.$frequency.' month', $current_return->period_start_date),$format);
            $vat_period_summary['last_submission_due_date'] = $this->helper->format_mysql_date($this->helper->get_next_date('-'.$frequency.' month', $current_return->period_due_date),$format);
            $vat_period_summary['next_period_end_date'] = $this->helper->format_mysql_date($this->helper->get_next_date('+'.$frequency.' month', $current_return->period_start_date),$format);
            $vat_period_summary['next_submission_due_date'] = $this->helper->format_mysql_date($this->helper->get_next_date('+'.$frequency.' month', $current_return->period_due_date),$format);
        }
        foreach ($tax_returns as $tax_return) {
            array_push($results,$this->accountsVatReturn->transform_tax_return($tax_return));
        }
        $paged_data['vat_period_summary'] = $vat_period_summary;
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        $user = $request->user();
        $vat_return_array = array();
        //return response()->json($http_resp);
        $company = $this->practices->find($user->company_id);
        $date_format = $company->date_format;
        $vatType = null;

        if($request->has('filters')){
            $custom_filters = json_decode($request->filters,true);
            Log::info($custom_filters);
            if($custom_filters['view_by']=='VAT Period'){
                $vat_return = $this->accountsVatReturn->findByUuid($custom_filters['vat_return_id']);
                if(!$vat_return){
                    $http_resp['results'] = $vat_return_array;
                    return response()->json($http_resp);
                }
            }
            //
            $vatType = $this->vatTypes->findByUuid($custom_filters['vat_type_id']);
            if($vatType){
                $vat_types = $this->accountsTaxations->getByUuid($vatType->uuid);
            }else{
                $vat_types = $this->accountsTaxations->all();
            }
        }else {
            $vat_return = $this->accountsVatReturn->findByUuid($uuid);
            $vat_types = $this->accountsTaxations->all();
        }
        //Get all VAT Types
        
        $vat_return_array = $this->accountsVatReturn->transform_tax_return($vat_return);
        $vat_return_array['total_output_transactions'] = 0;
        $vat_return_array['total_input_transactions'] = 0;
        ///////////////////////////////////////////////////
        $vat_period = null;
        if($vat_return->status == "Open"){
            $vat_period = "Current";
        }else{
            $vat_period = $vat_return->reference_number;
        }
        //
        $filters['start'] = $vat_return->period_start_date;
        $filters['end'] = $vat_return->period_due_date;
        //
        $transactions = array();
        
        foreach( $vat_types as $vat_type ){
            $vat_type_array = $this->accountsVatReturn->transform_vat_type($vat_type);
            $vat_type_array['vat_total'] = 0;
            $vat_type_array['excl_total'] = 0;
            $vat_type_array['incl_total'] = 0;
            //
            $vat_type_array['loc_supplier_excl_total'] = 0;
            $vat_type_array['loc_supplier_incl_total'] = 0;
            $vat_type_array['loc_supplier_vat_total'] = 0;
            //
            $vat_type_array['int_supplier_excl_total'] = 0;
            $vat_type_array['int_supplier_incl_total'] = 0;
            $vat_type_array['int_supplier_vat_total'] = 0;
            //
            $outputs_transactions = array();
            $inputs_transactions = array();
            //Find Company Taxation Record
            $company_taxation = $company->practice_taxations()->where('product_taxation_id',$vat_type->id)->get()->first();
            $company_taxation_ledger_ac = $company_taxation->ledger_accounts()->get()->first();
            
            //Vouchers on a given VAT Type during VAT Period
            $vouchers = $company_taxation_ledger_ac->vouchers($company_taxation_ledger_ac->code,$filters);
            //
            foreach( $vouchers as $voucher ){
                $support = $voucher->supports()->get()->first();
                $support_type = $support->trans_type;
                $transactionable = $support->transactionable()->get()->first();
                $transactionable_items = $transactionable->items()->get();

                $line_vat = 0;
                $line_incl = 0;
                $line_excl = 0;

                $total_incl = $transactionable->net_total;
                $total_excl = $total_incl;
                
                foreach($transactionable_items as $transactionable_item){

                    $price = $transactionable_item->prices()->get()->first();
                    $pack_cost = $price->pack_cost;
                    $qty = $transactionable_item->qty;
                    $taxed_rates = DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->table('bill_item_taxations')
                        ->where('bill_item_id',$transactionable_item->id)
                        ->where('product_taxation_id', $vat_type->id)
                        ->get();
                    $line_incl = $pack_cost * $qty;
                    $line_excl = $line_incl;
                    foreach($taxed_rates as $taxed_rate){
                        if($taxed_rate->purchase_rate > 0){
                            $line_vat += ( (($taxed_rate->purchase_rate/100)*$pack_cost) * $qty );
                        }
                    }
                    $line_excl = $line_incl - $line_vat;
                }
                $total_excl = $total_incl - $line_vat;

                // $line_tax = $transactionable->total_tax;
                // $line_net_tot = $transactionable->net_total;

                $temp_trans['id'] = $transactionable->uuid;
                $temp_trans['trans_date'] = $this->helper->format_mysql_date($transactionable->trans_date,$date_format);
                $temp_trans['trans_number'] = $transactionable->trans_number;
                $temp_trans['vat_period'] = $vat_period;
                $temp_trans['description'] = $support_type;
                $temp_trans['inclusive'] = $total_incl;
                $temp_trans['exclusive'] = $total_excl;
                $temp_trans['vat_amount'] = $line_vat;
                
                switch ($support_type) {
                    case $this->type_supplier_bill:
                        $supplier = $transactionable->suppliers()->get()->first();
                        $temp_trans['creditor_debtor_account'] = $this->suppliers->transform_supplier($supplier);
                        if($supplier->category == "Local"){
                            $vat_type_array['loc_supplier_vat_total'] += $line_vat;
                            $vat_type_array['loc_supplier_excl_total'] += $total_excl;
                            $vat_type_array['loc_supplier_incl_total'] += $total_incl;
                        }else{
                            $vat_type_array['int_supplier_vat_total'] += $line_vat;
                            $vat_type_array['int_supplier_excl_total'] += $total_excl;
                            $vat_type_array['int_supplier_incl_total'] += $total_incl;
                        }
                        $vat_type_array['vat_total'] += $line_vat;
                        $vat_type_array['excl_total'] += $total_excl;
                        $vat_type_array['incl_total'] += $total_incl;
                        $vat_return_array['total_input_tax'] += $line_vat;
                        $vat_return_array['total_purchases_incl'] += $total_incl;
                        $vat_return_array['total_purchases_excl'] += $total_excl;
                        array_push($inputs_transactions,$temp_trans);
                        $vat_return_array['total_input_transactions'] += 1;
                        break;
                    default:
                        $vat_return_array['total_output_transactions'] += 1;
                        break;
                }
            }
            $vat_type_array['input_tax'] = $inputs_transactions;
            $vat_type_array['output_tax'] = $outputs_transactions;
            array_push($transactions,$vat_type_array);
        }
        $vat_return_array['transactions'] = $transactions;
        $http_resp['results'] = $vat_return_array;
        ///////////////////////////////////////////////////
        return response()->json($http_resp);
    }

    public function reports(Request $request){
        $http_resp = $this->http_response['200'];
        Log::info($request);
        return response()->json($http_resp);
    }



    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'last_period_end_date'=>'required',
            'last_submission_due_date'=>'required',
            'vat_pin'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $last_period_end_date = $this->helper->format_lunox_date($request->last_period_end_date);
        $last_submission_due_date = $this->helper->format_lunox_date($request->last_submission_due_date);
        $last_day_of_month = date('d',\strtotime($last_period_end_date));

        if(!$this->helper->isPastDate($last_period_end_date)){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Last VAT Period End Date must be past date!'];
            return response()->json($http_resp,422);
        }

        if( !$this->helper->compare_two_dates($last_period_end_date,$last_submission_due_date) ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Last VAT Submission Due Date must be a day after 'Last VAT Period End Date'"];
            return response()->json($http_resp,422);
        }

        if( !($last_day_of_month==30 || $last_day_of_month==31) ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ["Each VAT period requires a submission and typically ends on the last day of the month"];
            return response()->json($http_resp,422);
        }

        $user = $request->user();
        $company = $this->practices->find($user->company_id);
        $date_format = $company->date_format;
        $vat_type = $this->accountsTaxations->findByVATPin($request->vat_pin);
        $frequency = $vat_type->filling_frequency;
        //;
        $next_period_end_date = $last_period_end_date;
        $next_period_start_date = $last_period_end_date;
        $next_submission_due_date = date('Y-m-d', strtotime('next month',\strtotime($last_submission_due_date)));
        for ($i=0; $i < $frequency; $i++) { 
            $next_period_start_date = date('Y-m-d', strtotime('first day of next month',\strtotime($next_period_start_date)));
            $next_period_end_date = date('Y-m-d', strtotime('last day of next month',\strtotime($next_period_end_date)));
        }
        $reference_number = date('m',\strtotime($next_period_end_date))."/".date('Y',\strtotime($next_period_end_date));
        if( $request->has('return_opening') ){
            $temp_results['last_period_end_date'] = $this->helper->format_mysql_date($last_period_end_date,$date_format);
            $temp_results['last_submission_due_date'] = $this->helper->format_mysql_date($last_submission_due_date,$date_format);
            $temp_results['next_period_end_date'] = $this->helper->format_mysql_date($next_period_end_date,$date_format);
            $temp_results['next_submission_due_date'] = $this->helper->format_mysql_date($next_submission_due_date,$date_format);
            $http_resp['description'] = "Congratulations! - you are one step away!";
            $http_resp['results'] = $temp_results;
            return response()->json($http_resp);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();

        try{

            $inputs['reference_number'] = $reference_number;
            $inputs['frequency'] = $frequency;
            $inputs['period_start_date'] = $next_period_start_date;
            $inputs['period_due_date'] = $next_period_end_date;
            $inputs['vat_pin'] = $vat_type->registration_number;
            $http_resp['description'] = "Successful created new VAT return!";
            $new_vat_return = $this->accountsVatReturn->create($inputs);
            $new_vat_return = $company->taxReturns()->save($new_vat_return);

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

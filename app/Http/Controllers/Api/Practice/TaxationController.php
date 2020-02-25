<?php

namespace App\Http\Controllers\Api\Practice;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\helpers\HelperFunctions;
use App\Models\Localization\Country;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;
use App\Models\Practice\Taxation\PracticeTaxation;
use App\Models\Users\User;
use App\Repositories\Localization\LocalizationRepository;
use App\Repositories\Practice\PracticeAssetRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Http\Controllers\Controller;

class TaxationController extends Controller
{
    //
    protected $practices;
    protected $practiceUser;
    protected $doctor;
    protected $patient;
    protected $http_response;
    protected $helper;
    protected $user;
    protected $role;
    protected $practice_asset;
    protected $pharmacy;
    protected $accountsCoa;
    protected $practiceTaxation;

    public function __construct(PracticeTaxation $practiceTaxation)
    {
        $this->practices = new PracticeRepository( new Practice() );
        $this->practiceTaxation = new PracticeRepository($practiceTaxation);
        $this->practice_asset = new PracticeAssetRepository(new PracticeAsset());
        $this->role = new RoleRepository(new Role());
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        if($request->has('input_tax')){
            $taxes = $company->practiceVatTypes()
                ->where('collected_on_purchase',true)
                ->orderByDesc('created_at')
                ->paginate(20);
        }elseif($request->has('output_tax')){
            $taxes = $company->practiceVatTypes()
                ->where('collected_on_sales',true)
                ->orderByDesc('created_at')
                ->paginate(20);
        }else{
            $taxes = $company->practiceVatTypes()->orderByDesc('created_at')->paginate(20);
        }

        $paged_data = $this->helper->paginator($taxes);
        foreach($taxes as $taxe){
            array_push($results,$this->practiceTaxation->transformPracticeTaxation($taxe));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rule1 = [
            'collected_on_purchase' => 'required',
            'collected_on_sales' => 'required',
            'name' => 'required',
            'tax_number' => 'required',
            'description' => 'required',
            'purchase_rate' => 'required',
            'sales_rate' => 'required',
            'status' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $company = $this->practices->find($request->user()->company_id);
        $company_owner = $company->owner()->get()->first();
        $vat_system = $company_owner->practice_taxations()->where('obligation','VAT')->where('tax_number',$request->tax_number)->get()->first();
        if(!$vat_system){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['Please provide a valid VAT Number to proceed'];
            return response()->json($http_resp,422);
        }

        if( $company->practiceVatTypes()->where('name',$request->name)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['VAT name already in use!'];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $sales_tax_ledger_code = AccountsCoa::AC_SALES_SERVICE_TAX_PAYABLE_CODE;
            $inputs = $request->all();
            $inputs['practice_id'] = $company->id; //Link VAT type to a company
            $vat_type = $vat_system->vatTaxations()->create($inputs); //Create new VAT Type, Linking it to VAT System
            //Create a Ledger account for this Tax Rate
            $sales_tax_ledger_ac = $company->chart_of_accounts()->where('default_code',$sales_tax_ledger_code)->where('is_sub_account',false)->where('is_special',true)->get()->first();
            $sub_ac_inputs['name'] = $vat_type->name;
            $tax_sub_accounts = $this->accountsCoa->create_sub_chart_of_account($company,$sales_tax_ledger_ac,$sub_ac_inputs,$vat_type);
            $http_resp['description'] = "Tax successful created!";

        }catch(\Exception $e){
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        $http_resp = $this->http_response['200'];
        $rule1 = [
            'collected_on_purchase' => 'required',
            'collected_on_sales' => 'required',
            'name' => 'required',
            'tax_number' => 'required',
            'description' => 'required',
            'purchase_rate' => 'required',
            'sales_rate' => 'required',
            'status' => 'required',
        ];
        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $company = $this->practices->find($request->user()->company_id);
        $vat_type = $this->practiceTaxation->findByUuid($uuid);
        $ledger_ac = $vat_type->ledger_accounts()->get()->first();
        if( $company->practiceVatTypes()->where('name',$request->name)->where('id','!=',$vat_type->id)->get()->first() ){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = ['VAT name already in use!'];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            if($request->is_default){
                $company->practiceVatTypes()->where('is_default',true)->update(['is_default'=>false]);
            }
            $vat_type->update($request->all());
            $ledger_ac->update($request->except(['is_default']));
            $http_resp['description'] = "Tax successful updated!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show($uuid){}

    public function destroy(Request $request, $uuid){
        $http_resp = $this->http_response['200'];
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $vat_type = $this->practiceTaxation->findByUuid($uuid);
            $ledger_ac = $vat_type->ledger_accounts()->get()->first();
            if($this->accountsCoa->getAccountTotalTransactions($ledger_ac) > 0){
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['Deletion failed!'];
                DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                return response()->json($http_resp,422);
            }else{
                $vat_type->forceDelete();
                $ledger_ac->forceDelete();
            }
        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            Log::info($e);
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }
}

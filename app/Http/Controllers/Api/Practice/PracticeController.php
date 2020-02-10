<?php

namespace App\Http\Controllers\Api\Practice;

use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\helpers\HelperFunctions;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeUsers;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeAssetRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Practice\PracticeUserRepository;
use App\Repositories\Product\ProductReposity;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Product\ProductType;
use App\Models\Hospital\Hospital;
use App\Models\Module\Module;
use App\Models\Practice\PracticeFinanceSetting;
use App\Models\Practice\PracticeUser;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;

class PracticeController extends Controller
{
    use ActivationTrait;
    protected $practice;
    protected $practiceUser;
    protected $doctor;
    protected $patient;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $role;
    protected $user_transformer;
    protected $practice_asset;
    protected $pharmacy;
    protected $accountsCoa;
    protected $suppliers;
    protected $customers;

    public function __construct(Practice $practice)
    {
        $this->practice = new PracticeRepository($practice);
        $this->practice_asset = new PracticeAssetRepository(new PracticeAsset());
        $this->role = new RoleRepository(new Role());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->patient = new PatientRepository(new Patient());
        $this->doctor = new DoctorRepository(new Doctor());
        $this->pharmacy = new PharmacyRepository(new Pharmacy());
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
        //$this->user_transformer = new UserTransformer();
        $this->practiceUser = new PracticeRepository(new PracticeUser());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $parentPractice = $this->practice->findParent($company);
        $facilities = $parentPractice->practices()->paginate(10);
        $paged_data = $this->helper->paginator($facilities);
        foreach( $facilities as $facility ){
            array_push($paged_data['data'],$this->practice->transform_($facility));
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $company = $this->practice->findByUuid($uuid);
        $users = array();
        $trans_data = $this->practice->transform_($company);
        $company_users = $company->users()->orderByDesc('created_at')->paginate(10);
        foreach ($company_users as $company_user) {
            array_push($users,$this->practiceUser->transform_user($company_user));
        }
        $trans_data['users'] = $users;
        $http_resp['results'] = $trans_data;
        return response()->json($http_resp);
    }

    public function delete($uuid){
        $http_resp = $this->response_type['200'];
        $this->practice->delete($uuid);
        $http_resp['description'] = "Company successful deleted";
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'registration_number' => 'required|unique:practices',
            'email' => 'required|unique:practices',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'propriator_title' => 'required',
            'website' => 'required',
            'postal_code' => 'sometimes|required',
            'business_type' => 'sometimes|required',
            'industry' => 'sometimes|required',

        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        //verify mobile
        // $encoded_mobile = $this->helper->encode_mobile($request->mobile);
        // if (!$encoded_mobile){
        //     $http_resp = $this->response_type['422'];
        //     $http_resp['errors'] = ['Invalid mobile number!'];
        //     return response()->json($http_resp,422);
        // }

        if ( ($request->website != "") && (!$this->helper->is_website_exist($request->website))){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Invalid website url'];
            return response()->json($http_resp,422);
        }

        /*
            Steps in Setting up a Company
            1. Create a company,
            2.  And Attach Company Financial Settings,
            3. Setup charts of accounts for a company
            4. Setup Payment methods for a company
            5. Setup Company Default supplier Terms
            6. Setup Company Default customer Terms
            7. If Logo is not provided let parent logo be default
            8. Set Default Government Taxation Rates
            9. Set Company Supplier Dashboard Widgets
            10. Configure Company Sales Tax Accounts
            11. If finance year begin date is not provided, default begin date should be 1st January of current Year, and END date to be 31st Dec of Current Year
        */
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        try{

            $new_company = $this->practice->create($request->all());
            $finance_settings = $new_company->practice_finance_settings()->save( new PracticeFinanceSetting() );
            if($request->has("file")){
                $rule = [
                    'file' => 'required|max:500000',
                ];
                $validation = Validator::make($request->all(), $rule);
                if ($validation->fails()){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                $doc_tmp_name = $_FILES['file']['tmp_name'];
                $root_directory_array = $this->helper->create_logo_directory($new_company->id);
                $newFilePath = $root_directory_array['file_server_root'].'/'.$_FILES['file']['name'];
                $file_path = $root_directory_array['file_public_access'].'/'.$_FILES['file']['name'];
                if(move_uploaded_file($doc_tmp_name, $newFilePath)){
                    $new_company->logo = $file_path;
                    $new_company->save();
                }
            }

            $default_company = $this->practice->find($request->user()->company_id);
            if($default_company){
                $head_quarter = $this->practice->findOwner($default_company);//Main Facility
                $the_enterprise = $this->practice->findParent($head_quarter); //Hospital()
                //Link newly created company to Main/Compny
                $new_company = $the_enterprise->practices()->save($new_company);
                if( !$request->has("file") ){
                    $new_company->logo = $default_company->logo;
                    $new_company->save();
                }
            }
            //Set Company Chart of Accounts
            $this->accountsCoa->company_coa_initialization($new_company);
            //Set Company Default Payment Methods
            $this->accountsCoa->company_payment_initialization($new_company);
            //Set Company Default Supplier Terms
            $this->suppliers->company_terms_initializations($new_company);
            //Set Company Default Customer Terms
            $this->customers->company_terms_initialization($new_company);

        }catch (\Exception $e){
            //$this->helper->delete_file($path_to_store);
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        // Log::info($request);
        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);

        $rules = [
            'address' => 'sometimes|required',
            'city' => 'sometimes|required',
            'country' => 'sometimes|required',
            'name' => 'sometimes|required',
            'status' => 'sometimes|required',
            'file' => 'sometimes|required|max:500000',
            'propriator_title' => 'sometimes|required',
            'website' => 'sometimes|required',
            'postal_code' => 'sometimes|required',
            'business_type' => 'sometimes|required',
            'industry' => 'sometimes|required',
            'registration_number' => 'sometimes|required|unique:practices,registration_number,'.$practice->id,
            'email' => 'sometimes|required|unique:practices,email,'.$practice->id,
            'mobile' => 'sometimes|required|unique:practices,mobile,'.$practice->id,
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{
            $this->practice->update($request->all(), $uuid);
            $http_resp['description'] = "Changes saved successful!";
            if($request->has("file")){
                $rule = [
                    'file' => 'required|max:500000',
                ];
                $validation = Validator::make($request->all(), $rule);
                if ($validation->fails()){
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }
                $doc_tmp_name = $_FILES['file']['tmp_name'];
                $root_directory_array = $this->helper->create_logo_directory($practice->id);
                $newFilePath = $root_directory_array['file_server_root'].'/'.$_FILES['file']['name'];
                $file_path = $root_directory_array['file_public_access'].'/'.$_FILES['file']['name'];
                if(move_uploaded_file($doc_tmp_name, $newFilePath)){
                    $practice->logo = $file_path;
                    $practice->save();
                    $http_resp['description'] = "Company Logo successful saved";
                }
            }
            
        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

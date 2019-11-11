<?php

namespace App\Http\Controllers\Api\Practice;

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
        //$this->user_transformer = new UserTransformer();
        //$this->practiceUser = new PracticeUserRepository(new PracticeUsers());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $parentPractice = $this->practice->findParent($company);
        $facilities = $parentPractice->practices()->get();
        foreach( $facilities as $facility ){
            array_push($results,$this->practice->transform_($facility));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    // public function facilities($facility_id){
    //     $http_resp = $this->response_type['200'];
    //     $practice = $this->practice->findByUuid($facility_id);
    //     $parent_main = $this->practice->findParent($practice);
    //     $branches = $parent_main->practices()->get()->sortBy('name');
    //     $results = array();
    //     foreach($branches as $branch){
    //         $data['id'] = $branch->uuid;
    //         $data['name'] = $branch->name;
    //         $data['address'] = $branch->address;
    //         $data['email'] = $branch->email;
    //         $data['longitude'] = $branch->longitude;
    //         $data['latitude'] = $branch->latitude;
    //         $data['mobile'] = $branch->mobile;
    //         array_push($results,$data);
    //     }
    //     $http_resp['results'] = $results;
    //     return response()->json($http_resp);
    // }

    public function practice($uuid){
        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);
        //$owner = $practice->owner()->get()->first();
        $parent_main = $this->practice->findParent($practice);
        $branches = $parent_main->practices()->get();
        $http_resp['results'] = $this->practice->transform_collection($branches);
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->practice->transform_($this->practice->findByUuid($uuid));
        return response()->json($http_resp);
    }

    public function show_resource_based(Request $request, $uuid, $resource_type){

        $company = $this->practice->find($request->user()->company_id);
       
        $http_resp = $this->response_type['200'];
        switch ($resource_type){
            case "Product Items":
                $prodRepo = new ProductReposity(new PracticeProductItem());
                $http_resp['results'] = $prodRepo->getProductItem($this->practice->findByUuid($uuid));
                break;
            case "Drug":
            case "Equipment":
            case "Supplies":
                $prodRepo = new ProductReposity(new PracticeProductItem());
                $itemRepo = new ProductReposity(new ProductType());
                $item_type = $itemRepo->findByName($resource_type);
                $arr['column'] = 'product_type_id';
                $arr['value'] = $item_type->id;
                $prodRepo = new ProductReposity(new PracticeProductItem());
                $http_resp['results'] = $prodRepo->getProductItem($this->practice->findByUuid($uuid),$arr);
                break;
            case "Account Holders": //
                $prodRepo = new ProductReposity(new Practice());
                $resource = $prodRepo->getAccountHolders($this->practice->findByUuid($uuid));
                $http_resp['results'] = $resource;
                break;
            case "Banks": //
                $prodRepo = new ProductReposity(new Practice());
                $http_resp['results'] = $prodRepo->getBanks($this->practice->findByUuid($uuid));
                break;
            case "Purchases":
                $prodRepo = new ProductReposity(new ProductPurchase());
                $http_resp['results'] = $prodRepo->getPurchases($this->practice->findByUuid($uuid));
                break;
            case "ICC":
                $results = array();
                for ( $i=1; $i<31; $i++){
                    $temp_data['date'] = date("Y-m-d",strtotime("2019-06-".$i));
                    $temp_data['max_level'] = 3000000;
                    $temp_data['buffer_level'] = 500000;
                    $temp_data['reorder_level'] = 1200000;
                    $temp_data['purchased'] = rand(1000, 500000);
                    $temp_data['sold'] = rand(1000, 500000);
                    $temp_data['stock_level'] = rand(1000, 3000000);
                    array_push($results,$temp_data);
                }

                $stock_ou['facility'] = "(Amref Langata Main)";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[0] = $stock_ou;
                $stock_ou['facility'] = "Amref Upper Hill";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[1] = $stock_ou;
                $stock_ou['facility'] = "Amref Westlands";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[2] = $stock_ou;
                $stock_ou['facility'] = "Amref Buruburu";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[3] = $stock_ou;
                $stock_ou['facility'] = "Amref Embakasi";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[4] = $stock_ou;
                $stock_ou['facility'] = "Amref Thika";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[5] = $stock_ou;
                $stock_ou['facility'] = "Amref Kibera";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[6] = $stock_ou;
                $stock_ou['facility'] = "Amref Karen";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[7] = $stock_ou;
                $stock_ou['facility'] = "Amref Nakuru";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[8] = $stock_ou;
                $stock_ou['facility'] = "Amref Eldoret";
                $stock_ou['percentage_amount'] = rand(1, 100);
                $stock_ou['amount'] = rand(90000, 1200000);
                $stock_out[9] = $stock_ou;

                $stock_out_item['name'] = "Amoxicillin 250mg Capsules 10";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[0]= $stock_out_item;
                $stock_out_item['name'] = "USN Blue Lab Whey Protein Chocolate 454g";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[1]= $stock_out_item;
                $stock_out_item['name'] = "USN Blue Protein Chocolate 500g";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[2]= $stock_out_item;
                $stock_out_item['name'] = "Amoxicillin";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[3]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[4]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[5]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[6]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[7]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[8]= $stock_out_item;
                $stock_out_item['name'] = "Acetaminophen";
                $stock_out_item['total_facility'] = rand(1, 50);
                $stock_out_item['alternatives'] = rand(1, 100);
                $stock_out_items[9]= $stock_out_item;

                $results2['stock_movement'] = $results;
                $results2['stock_out'] = $stock_out;
                $results2['stock_out_items'] = $stock_out_items;
                $http_resp['results'] = $results2;
                break;
            case "Medicine Category":
            case "Product Category":
            case "Product Type":
            case "Accounts":
            case "Units":
            case "Account Nature":
            case "Account Type":
            case "Brands":
            case "Branches":
            case "Currency":
            case "Human Resource":
            case "Brand Sector":
            case "Payment Methods":
            case "Departments":
            case "Suppliers":
                $practice = $this->practice->findByUuid($uuid);
                $practice_main = $this->practice->findOwner($practice);
                $http_resp['results'] = $this->practice->transform_($practice_main,$resource_type);
                break;
            case "Items Page Initialization":
            // case "Taxes":
            //     $http_resp['results'] = $this->practice->transform_($this->practice->findByUuid($uuid),$resource_type);
            //     break;
            case "Practices":
                $http_resp['results'] = $this->practice->transform_($company,$resource_type);
                break;
            default:
                $http_resp['results'] = $this->practice->transform_($company,$resource_type);
                break;
        }
        return response()->json($http_resp);
    }

    public function delete($uuid){
        $http_resp = $this->response_type['200'];
        $this->practice->delete($uuid);
        $http_resp['description'] = "Branch successful deleted";
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];
        $rules = [
//            'clinic_logo' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
//            'verification_certificate' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'name' => 'required',
            //'user_id' => 'required',
            'address' => 'required',
            'registration_number' => 'required|unique:practices',
            'email' => 'required|unique:practices',
            'mobile' => 'required|unique:practices',
            'country' => 'required',
            'city' => 'required',
            //'website' => 'required|unique:practices',
            'type' => 'required',
            'practice_id' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        //verify mobile
        $encoded_mobile = $this->helper->encode_mobile($request->mobile);
        if (!$encoded_mobile){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Invalid mobile number!'];
            return response()->json($http_resp,422);
        }

        if ( ($request->website != "") && (!$this->helper->is_website_exist($request->website))){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Invalid website url'];
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $inputs = $request->except(['practice_id']);
            $inputs['mobile'] = $encoded_mobile;
            $practice_main = $this->practice->findByUuid($request->practice_id);
            $practice_main = $this->practice->findOwner($practice_main);
            $owner = $practice_main->owner()->get()->first();
            $practice = $owner->practices()->create($inputs);
            $otp_code = $this->helper->getCode(5);
            $otp['token'] = $otp_code;
            $sms = "Hi ".$owner->name."\n";
            $sms .= "Your one-time-password is ".$otp_code." valid until 24 hours. Please key in to complete your ".$practice->name." branch registration.";
            $this->practice->create_activation($practice, $otp);
            //$this->initiateSms($encoded_mobile, $sms);
            $http_resp['results'] = $this->practice->transform_($practice);
            $http_resp['description'] = "OTP was sent to ".$encoded_mobile.". Please key in to continue";

        }catch (\Exception $e){
            //$this->helper->delete_file($path_to_store);
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);
        $rules = [
            'address' => 'sometimes|required',
            'city' => 'sometimes|required',
            'country' => 'sometimes|required',
            'name' => 'sometimes|required',
            'status' => 'sometimes|required',
            'type' => 'sometimes|required',
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
        $this->practice->update($request->all(), $uuid);
        $http_resp['description'] = "Changes saved successful!";
        $http_resp['results'] = $this->practice->transform_($practice);
        return response()->json($http_resp);
    }





    public function preferred(Request $request){

        $http_resp = $this->response_type['200'];

        $rules = [
            'practice_id' => 'required',
            'patient_id' => 'required',
        ];
        $msg = [
            'practice_id.required' => 'Facility ID required',
            'patient_id.required' => 'Patient ID required'
        ];
        $validation = Validator::make($request->all(),$rules,$msg);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

//        Log::info($request);
//        Log::info($request);

        DB::beginTransaction();
        try{

            $patient = $this->patient->findByUuid($request->patient_id);
            $practice = $this->practice->findByUuid($request->practice_id);
            if ($this->patient->check_preference($patient->id, $practice->id)){
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Pharmacy already in your preferred list'];
                return response()->json($http_resp,422);
            }
            $this->patient->setPreferredPharmacy($patient, $practice);

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }



    public function practice_users($uuid){

        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);
        $practice_users = $this->practiceUser->getByPracticeId($practice->id);

        $response = [

            'pagination' => [
                'total' => $practice_users->total(),
                'per_page' => $practice_users->perPage(),
                'current_page' => $practice_users->currentPage(),
                'last_page' => $practice_users->lastPage(),
                'from' => $practice_users->firstItem(),
                'to' => $practice_users->lastItem()
            ],
            'data' => $this->user_transformer->transformPracticeUsers($practice_users, $uuid)
        ];
        $http_resp['results'] = $response;
        return response()->json($http_resp);
    }

    public function create_users(Request $request, $uuid){

        $http_resp = $this->response_type['200'];
        $rule = [
            'user_role' => 'required',
            'email' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($uuid);
            $user = $this->user->findByEmail($request->email);
            $user_role = $this->role->find($request->user_role);
            if (!$user){
                $user = $this->user->storeRecord($request->all());
                if ($user_role->slug == 'doctor'){
                    $this->user->setDoctor($user, $request->except(['email','mobile']));
                }elseif ($user_role->slug == 'patient'){
                    $this->user->setPatient($user, $request->except(['email','mobile']));
                }elseif ($user_role->slug == 'receptionist'){

                }
                $this->user->attachRole($user, $user_role->slug);
            }
            //check if user already exists in practice
            if ($this->user->exist_in_practice($user, $practice)){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['User with similar email already invited in this practice'];
                return response()->json($http_resp,422);
            }
            //add user to practice
            $this->user->attachToPractice($user, $practice);
            //attach practice role to user
            $practice_user = $this->practiceUser->findPracticeUser($practice, $user);
            $this->practiceUser->setConfirmed($practice_user, false);
            $this->practiceUser->attachRole($practice_user, $user_role);
            //send user an email
            $inviter_name = $practice->name;
            $this->initiatePracticeUserInvitation($user, $practice);
        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp, 500);
        }

        DB::commit();
        return response()->json($http_resp);
    }

}

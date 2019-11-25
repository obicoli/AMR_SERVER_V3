<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Models\Supplier\Supplier;
use App\Repositories\Supplier\SupplierRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use Illuminate\Support\Facades\DB;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Repositories\User\UserRepository;
use App\Models\Users\User;
use App\Repositories\Accounts\AccountingRepository;
use App\Models\Account\Vendors\AccountVendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    protected $supplier;
    protected $response_type;
    protected $helper;
    protected $practice;
    protected $user;
    protected $accountSupplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = new SupplierRepository($supplier);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practice = new PracticeRepository( new Practice());
        $this->user = new UserRepository(new User());
        $this->accountSupplier = new AccountingRepository(new AccountVendor());
    }

    public function index( $facility_id =null ){

        $http_resp = $this->response_type['200'];

        $results = array();

        if($facility_id){
            $practice = $this->practice->findByUuid($facility_id);
            $practiceParent = $this->practice->findParent($practice);
            $suppliers = $this->accountSupplier->getVendors($practiceParent,'supplier');
        }

        $http_resp['results'] = $results;

        return response()->json($http_resp);

    }
    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'practice_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{

            $practice = $this->practice->findByUuid($request->practice_id);
            $practiceParent = $this->practice->findParent($practice);
            $user = $this->user->findByEmail($request->email);
            $inpo = $request->all();
            if(!$user){
                $inpo['status'] = "Activated";
                $user = $this->user->storeRecord($inpo);
                $this->user->attachRole($user,'supplier');
                //$supplier = $user->supplier()->create($inpo);
            }
            $supplier = $user->supplier()->get()->first();
            if(!$supplier){
                $inpo2['name'] = $request->company;
                $inpo2['phone'] = $request->phone;
                $inpo2['email'] = $request->email;
                $inpo2['address'] = $request->address;
                $supplier = $user->supplier()->create($inpo2);
            }
            //$inpo['practice_id'] = $practice_main->id;
            //$this->practice->setVendor($supplier, $inpo);
            $inputs = $request->all();
            $inputs['vendor_type'] = "supplier";
            $this->accountSupplier->getOrCreate($practiceParent,$inputs);

        }catch(\Exception $ex){
            Log::info($ex);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function upload(Request $request){

        $http_resp = $this->response_type['200'];
        $rules = [
            'practice_id' => 'required',
            // 'vendor_type' => 'required',
            // 'notes' => 'required',
            // 'first_name' => 'required',
            // 'other_name' => 'required',
            // 'middle_name' => 'required',
            // 'company' => 'required',
            // 'postal_code' => 'required',
            // 'country' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            // 'fax' => 'required',
            // 'phone' => 'required',
            // 'terms' => 'required',
            // 'bill_rate' => 'required',
            // 'business_id' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        Log::info($request);
        return response()->json($http_resp);

    }

    public function show($uuid){}

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        DB::beginTransaction();
        try{
            $supplier = $this->accountSupplier->findByUuid($uuid);
            $supplier->update($request->all());
        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function delete($uuid){}

}

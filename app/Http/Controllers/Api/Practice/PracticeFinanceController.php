<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeAssetRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Module\Module;
use App\Models\Practice\PracticeFinanceSetting;

class PracticeFinanceController extends Controller
{
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
    protected $financeSettings;

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
        $this->financeSettings = new PracticeRepository( new PracticeFinanceSetting() );
        //$this->user_transformer = new UserTransformer();
        //$this->practiceUser = new PracticeUserRepository(new PracticeUsers());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $company = $this->practice->find($request->user()->company_id);
        $finance_settings = $company->practice_finance_settings()->get()->first();
        $http_resp['results'] = $this->practice->transform_finance_settings($finance_settings);
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){

        $http_resp = $this->response_type['200'];

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        try{

            $settings = $this->financeSettings->findByUuid($uuid);
            $settings->update($request->except(['uuid']));
            $http_resp['description'] = "Successful saved!";

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

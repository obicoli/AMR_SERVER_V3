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

class PracticeFinanceController extends Controller
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
}

<?php

namespace App\Http\Controllers\Api\Emr\Health;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Surgery;
use App\Models\Patient\Patient;
use App\Models\Users\User;
use App\Repositories\Emr\DEL\EmrRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SurgeryController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $surgery;
    protected $user;
    protected $patient;

    public function __construct(Surgery $surgery)
    {
        $this->surgery = new EmrRepository($surgery);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->patient = new PatientRepository(new Patient());
    }

    public function index(Request $request){

        $user = $request->user();
        switch ( $this->user->getUserType($user) ){
            case Patient::USER_TYPE:
                $patient = $this->patient->findPatientByUserId($user->id);
                break;
        }

    }
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

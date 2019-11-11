<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\ExecuseActivity;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ExecuseActivityController extends Controller
{
    protected $execuseActivity;
    protected $http_response;

    public function __construct(ExecuseActivity $execuseActivity)
    {
        $this->execuseActivity = new PrescriptionRepository($execuseActivity);
        $this->http_response = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->execuseActivity->all();
        return response()->json($http_resp);
    }

}

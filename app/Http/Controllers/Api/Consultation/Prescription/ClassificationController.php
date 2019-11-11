<?php

namespace App\Http\Controllers\Api\Consultation\Prescription;

use App\Models\Consultation\Prescription\Classfication;
use App\Repositories\Consultation\Prescription\PrescriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ClassificationController extends Controller
{
    protected $classfication;
    protected $http_response;

    public function __construct(Classfication $classfication)
    {
        $this->classfication = new PrescriptionRepository($classfication);
        $this->http_response = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->classfication->all();
        return response()->json($http_resp);
    }

}

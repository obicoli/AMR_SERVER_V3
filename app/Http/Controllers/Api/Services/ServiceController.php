<?php

namespace App\Http\Controllers\Api\Services;

use App\Models\Service\Service;
use App\Repositories\Services\Service\ServiceRepository;
use App\Transformers\Services\ServiceTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    //
    protected $service;
    protected $http_response;

    public function __construct(Service $service)
    {
        $this->service = new ServiceRepository($service);
        $this->http_response = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $services = $this->service->all();
        $http_resp['results'] = $this->service->transform_collection($services);
        return response()->json($http_resp);
    }

}

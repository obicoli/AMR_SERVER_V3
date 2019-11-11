<?php

namespace App\Http\Controllers\Api\Specialist;

use App\Models\Specialist\Domains;
use App\Models\Specialist\Specialist;
use App\Repositories\Specialist\SpecialistRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\Specialist\DomainRepository;
use Illuminate\Support\Facades\Config;
use App\Transformers\Specialist\SpecialistTransformer;

class SpecialistController extends Controller
{

    protected $specialist;
    protected $domains;
    protected $response_type;
    protected $transformer;


    public function __construct(Specialist $specialist, Domains $domains)
    {
        $this->specialist = new SpecialistRepository($specialist);
        $this->domains = new DomainRepository($domains);
        $this->response_type = Config::get('response.http');
        $this->transformer = new SpecialistTransformer();
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->transformer->tranformSpecialistCollection($this->specialist->all());
        return response()->json($http_resp);
    }

    public function getSpecialistByDomain($domain_id){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->transformer->tranformSpecialistCollection($this->specialist->all());
        return response()->json($http_resp);
    }

}

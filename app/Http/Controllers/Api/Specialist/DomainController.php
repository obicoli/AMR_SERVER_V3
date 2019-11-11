<?php

namespace App\Http\Controllers\Api\Specialist;

use App\Models\Specialist\Domains;
use App\Models\Specialist\Specialist;
use App\Repositories\Specialist\DomainRepository;
use App\Repositories\Specialist\SpecialistRepository;
use App\Transformers\Specialist\SpecialistTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class DomainController extends Controller
{
    protected $domain;
    protected $specialist;
    protected $response_type;
    protected $transformer;

    public function __construct(Domains $domain, Specialist $specialist)
    {
        $this->domain = new DomainRepository($domain);
        $this->specialist = new SpecialistRepository($specialist);
        $this->response_type = Config::get('response.http');
        $this->transformer = new SpecialistTransformer();
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->transformer->tranformDomainCollection($this->domain->all());
        return response()->json($http_resp);
    }

}

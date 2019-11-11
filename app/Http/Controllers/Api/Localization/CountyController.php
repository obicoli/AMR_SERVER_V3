<?php

namespace App\Http\Controllers\Api\Localization;

use App\Models\Localization\County;
use App\Repositories\Localization\LocalizationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class CountyController extends Controller
{
    protected $county;
    protected $response_type;

    public function __construct(County $county)
    {
        $this->county = new LocalizationRepository($county);
        $this->response_type = Config::get('response.http');
    }

    public function index(){
        $counties = $this->county->all();
        $results = array();
        foreach ($counties as $county){
            $temp_data['id'] = $county->uuid;
            $temp_data['name'] = $county->name;
            $temp_data['region_id'] = $county->region()->get()->first()->uuid;
            array_push($results, $temp_data);
        }
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }
    public function create(Request $request){}
    public function update(Request $request, $uuid){}
    public function show($uuid){}
    public function delete($uuid){}

}

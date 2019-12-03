<?php

namespace App\Http\Controllers\Api\Localization;

use App\Models\Localization\Country;
use App\Repositories\Localization\LocalizationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class CountryController extends Controller
{
    //
    protected $response_type;
    protected $country;

    public function __construct(Country $country)
    {
        $this->response_type = Config::get('response.http');
        $this->country = new LocalizationRepository($country);
    }

    public function index(){
        $countries = $this->country->all();
        $results = array();
        foreach ($countries as $country){
            array_push($results, $this->country->transform_country($country) );
        }
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

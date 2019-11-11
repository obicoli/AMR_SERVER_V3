<?php

namespace App\Http\Controllers\Api\Localization;

use App\Models\Localization\City;
use App\Models\Localization\Country;
use App\Models\Localization\County;
use App\Repositories\Localization\CityRepository;
use App\Repositories\Localization\CountryRepository;
use App\Repositories\Localization\LocalizationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CityController extends Controller
{
    protected $city;
    protected $response_type;
    protected $country;

    public function __construct(City $city)
    {
        $this->response_type = Config::get('response.http');
        $this->city = new LocalizationRepository($city);
        $this->country = new LocalizationRepository(new Country());
    }

    public function index(){

        $cities = $this->city->all();
        $results = array();
        foreach ($cities as $citie){
            $temp_data['id'] = $citie->uuid;
            $temp_data['name'] = $citie->name;
            array_push($results, $temp_data);
        }
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $results;
        return response()->json($http_resp);

    }

    public function country($name){
        $country = $this->country->findByName($name);
        $http_resp = $this->response_type['200'];
        $results = array();
        if ($country){
            $cities = $this->city->findByCountryId($country->id);
            foreach ($cities as $citie){
                $temp_data['id'] = $citie->id;
                $temp_data['name'] = $citie->name;
                $temp_data['country_id'] = $citie->country_id;
                array_push($results, $temp_data);
            }
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

}

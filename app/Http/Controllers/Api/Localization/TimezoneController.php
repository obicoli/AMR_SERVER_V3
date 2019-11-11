<?php

namespace App\Http\Controllers\Api\Localization;

use App\Models\Localization\TimeZones;
use App\Repositories\Localization\TimezoneRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class TimezoneController extends Controller
{
    //
    protected $timezone;
    protected $response_type;

    public function __construct(TimeZones $timezone)
    {
        $this->response_type = Config::get('response.http');
        $this->timezone = new TimezoneRepository($timezone);
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->timezone->all();
        return response()->json($http_resp);
    }

}

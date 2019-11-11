<?php

namespace App\Http\Controllers\Api\Patient;

use App\helpers\HelperFunctions;
use App\Models\Patient\HealthProfile;
use App\Repositories\ModelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class HealthHistoryController extends Controller
{
    protected $healthProfile;
    protected $response_type;
    protected $transformer;
    protected $helper;

    public function __construct(HealthProfile $healthProfile)
    {
        $this->healthProfile = new ModelRepository($healthProfile);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function destroy($uuid){}
    public function create(Request $request){}
    public function show($uuid){}
    public function update(Request $request, $uuid){}
}

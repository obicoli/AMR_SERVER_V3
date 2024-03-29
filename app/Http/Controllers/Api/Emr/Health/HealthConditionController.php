<?php

namespace App\Http\Controllers\Api\Emr\Health;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\HealthCondition;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class HealthConditionController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $healthCondition;

    public function __construct(HealthCondition $healthCondition)
    {
        $this->healthCondition = new EmrRepository($healthCondition);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

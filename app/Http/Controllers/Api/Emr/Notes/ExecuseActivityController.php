<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\ExecuseActivity;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ExecuseActivityController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $excuseActivity;

    public function __construct(ExecuseActivity $excuseActivity)
    {
        $this->excuseActivity = new EmrRepository($excuseActivity);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

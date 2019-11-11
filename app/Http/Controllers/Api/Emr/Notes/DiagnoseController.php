<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\Diagnose;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class DiagnoseController extends Controller
{

    protected $helper;
    protected $http_response;
    protected $diagnose;

    public function __construct(Diagnose $diagnose)
    {
        $this->diagnose = new EmrRepository($diagnose);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}

}

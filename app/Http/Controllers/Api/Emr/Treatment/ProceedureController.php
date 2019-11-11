<?php

namespace App\Http\Controllers\Api\Emr\Treatment;

use App\helpers\HelperFunctions;
use App\Models\Emr\Treat\Proceedure;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ProceedureController extends Controller
{
    //
    protected $helper;
    protected $http_response;
    protected $proceedure;

    public function __construct(Proceedure $proceedure)
    {
        $this->proceedure = new EmrRepository($proceedure);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

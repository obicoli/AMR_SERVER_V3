<?php

namespace App\Http\Controllers\Api\Emr\Lab;

use App\helpers\HelperFunctions;
use App\Models\Emr\Orders\LabOrder;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LabOrderController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $labOrder;

    public function __construct(LabOrder $labOrder)
    {
        $this->labOrder = new EmrRepository($labOrder);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

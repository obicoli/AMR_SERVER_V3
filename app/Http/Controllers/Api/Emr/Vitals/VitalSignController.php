<?php

namespace App\Http\Controllers\Api\Emr\Vitals;

use App\helpers\HelperFunctions;
use App\Models\Emr\Vitals\VitalSign;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class VitalSignController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $vitalSign;

    public function __construct(VitalSign $vitalSign)
    {
        $this->vitalSign = new EmrRepository($vitalSign);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

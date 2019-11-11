<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\Referral;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ReferralController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $referral;

    public function __construct(Referral $referral)
    {
        $this->referral = new EmrRepository($referral);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

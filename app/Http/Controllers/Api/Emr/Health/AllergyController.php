<?php

namespace App\Http\Controllers\Api\Emr\Health;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Allergies;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class AllergyController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $allergies;

    public function __construct(Allergies $allergies)
    {
        $this->allergies = new EmrRepository($allergies);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\Complaint;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ComplaintController extends Controller
{

    protected $helper;
    protected $http_response;
    protected $complaint;

    public function __construct(Complaint $complaint)
    {
        $this->complaint = new EmrRepository($complaint);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}

}

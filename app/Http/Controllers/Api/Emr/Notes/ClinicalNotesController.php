<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\ClinicalNotes;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class ClinicalNotesController extends Controller
{
    protected $helper;
    protected $http_response;
    protected $clinicalNotes;

    public function __construct(ClinicalNotes $clinicalNotes)
    {
        $this->clinicalNotes = new EmrRepository($clinicalNotes);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}
}

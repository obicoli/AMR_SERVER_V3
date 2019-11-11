<?php

namespace App\Http\Controllers\Api\Emr\Notes;

use App\helpers\HelperFunctions;
use App\Models\Emr\Notes\SickNote;
use App\Repositories\Emr\DEL\EmrRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SickNoteController extends Controller
{

    protected $helper;
    protected $http_response;
    protected $sickNote;

    public function __construct(SickNote $sickNote)
    {
        $this->sickNote = new EmrRepository($sickNote);
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
    }

    public function index(){}
    public function show($uuid){}
    public function destroy(Request $request,$uuid){}
    public function update(Request $request, $uuid){}
    public function create(Request $request){}

}

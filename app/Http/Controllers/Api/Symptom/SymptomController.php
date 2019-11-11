<?php

namespace App\Http\Controllers\Api\Symptom;

use App\Models\Symptom\Symptom;
use App\Models\Symptom\SymptomCategory;
use App\Repositories\Symptom\SymptomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SymptomController extends Controller
{
    protected $response_type;
    protected $symptom;
    protected $symptomCategory;
    protected $transformer;

    public function __construct(Symptom $symptom, SymptomCategory $symptomCategory)
    {
        $this->symptom = new SymptomRepository($symptom);
        $this->symptomCategory = new SymptomRepository($symptomCategory);
        $this->response_type = Config::get('response.http');
    }

    public function index(){

    }

    public function categories(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->transformer->transformCategoryCollection($this->symptomCategory->all());
        return response()->json($http_resp);
    }

    public function patient_symptoms($patient_id){

    }

    public function create_symptom(Request $request){

    }

}

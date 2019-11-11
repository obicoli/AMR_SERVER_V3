<?php

namespace App\Http\Controllers\Api\Symptom;

use App\Models\Symptom\Symptom;
use App\Models\Symptom\SymptomCategory;
use App\Repositories\Symptom\SymptomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class CategoryController extends Controller
{
    protected $response_type;
    protected $symptom;
    protected $symptomCategory;

    public function __construct(Symptom $symptom, SymptomCategory $symptomCategory)
    {
        $this->symptom = new SymptomRepository($symptom);
        $this->symptomCategory = new SymptomRepository($symptomCategory);
        $this->response_type = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $categories = $this->symptomCategory->all();
        $http_resp['results'] = $this->symptomCategory->transform_category_collection($categories);
        return response()->json($http_resp);
    }
}

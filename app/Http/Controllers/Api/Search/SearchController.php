<?php

namespace App\Http\Controllers\Api\Search;

use App\helpers\HelperFunctions;
use App\Models\Emr\Health\Allergies;
use App\Models\Emr\Health\HealthCondition;
use App\Models\Emr\Health\Medication;
use App\Models\Emr\Health\Surgery;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Department;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Product;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Repositories\Emr\EmrRepository;
use App\Repositories\ModelRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;

class SearchController extends Controller
{
    protected $model;
    protected $response_type;
    protected $practice;
    protected $helper;
    protected $productRepository;

    public function __construct()
    {
        $this->response_type = Config::get('response.http');
        $this->practice = new PracticeRepository(new Practice());
        $this->helper = new HelperFunctions();
        $this->productRepository = new ProductReposity(new Product());
    }

    public function search(Request $request, $type){

        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($request->practice_id);
        switch ($type){
            case "pharmacy": //search pharmacy: Practices where type = "pharmacy"
                $this->model = new ModelRepository(new Practice());
                $practice = new PracticeRepository(new Practice());
                $pharmacies = $this->model->search($request->all(),$type);
                $http_resp['results'] = $practice->transform_collection($pharmacies);
                break;
            case "conditions":
                $this->model = new ModelRepository(new HealthCondition());
                $condition = new EmrRepository(new HealthCondition());
                $conditions = $this->model->search($request->all(),$type);
                $http_resp['results'] = $condition->transform_collection($conditions);
                break;
            case "medications":
                $this->model = new ModelRepository(new Medication());
                $medication = new EmrRepository(new Medication());
                $medications = $this->model->search($request->all(),$type);
                $http_resp['results'] = $medication->transform_collection($medications);
                break;
            case "allergies":
                $this->model = new ModelRepository(new Allergies());
                $allergy = new EmrRepository(new Allergies());
                $allergies = $this->model->search($request->all(),$type);
                $http_resp['results'] = $allergy->transform_collection($allergies);
                break;
            case "surgeries":
                $this->model = new ModelRepository(new Surgery());
                $surgery = new EmrRepository(new Surgery());
                $surgeries = $this->model->search($request->all(),$type);
                $http_resp['results'] = $surgery->transform_collection($surgeries);
                break;
            case "departments":
                $this->model = new ModelRepository(new Department());
                $departments = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($departments);
                break;
            case "roles":
            case "HR":
                $this->model = new ModelRepository(new Role());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "branches": //here you post main_practice_id & name of the practice you are searching
                $practRepo = new PracticeRepository(new Practice());
                $practice = $practRepo->findByUuid($request->main_practice_id);
                break;
            case "products":
                $this->model = new ModelRepository(new Product());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "product_name": //product name
                $practRepo = new PracticeRepository(new Practice());
                $practice = $practRepo->findByUuid($request->practice_id);
                $practice = $practRepo->findOwner($practice);
                $inputs = $request->all();
                //Log::info($practice);
                $inputs['practice_id'] = $practice->id;
                $this->model = new ModelRepository(new Product());
                $roles = $this->model->search($inputs,$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "generics":
                $this->model = new ModelRepository(new ProductGeneric());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "barcode":
                $this->model = new ModelRepository(new PracticeProductItem());
                $roles = $this->model->search($request->all(),$type);
                if ($roles){
                    $http_resp['results'] = true;
                }else{
                    $http_resp['results'] = false;
                }
                break;
            case "item_code":
                $this->model = new ModelRepository(new PracticeProductItem());
                $roles = $this->model->search($request->all(),$type);
                if ($roles){
                    $http_resp['results'] = true;
                }else{
                    $http_resp['results'] = false;
                }
                break;
            case "manufacturers":
                $this->model = new ModelRepository(new Manufacturer());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "Brands":
                $this->model = new ModelRepository(new ProductBrand());
                $parentPractice = $this->practice->findParent($practice);
                $brands = $this->model->search($request->all(),$type, $parentPractice);
                $res = array();
                $paged_data = $this->helper->paginator($brands);
                foreach ($brands as $brand){
                    array_push($res, $this->productRepository->transform_($brand));
                }
                $paged_data['data'] = $res;
                $http_resp['results'] = $paged_data;
                // $this->model = new ModelRepository(new ProductBrand());
                // $roles = $this->model->search($request->all(),$type);
                // $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "brand_sector":
                $this->model = new ModelRepository(new ProductBrandSector());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "units":
                $this->model = new ModelRepository(new ProductUnit());
                $roles = $this->model->search($request->all(),$type);
                $http_resp['results'] = $this->model->transform_collection($roles);
                break;
            case "Category":
                $this->model = new ModelRepository(new ProductCategory());
                $parentPractice = $this->practice->findParent($practice);
                $categories = $this->model->search($request->all(),$type, $parentPractice);
                $res = array();
                $paged_data = $this->helper->paginator($categories);
                foreach ($categories as $category){
                    array_push($res, $this->productRepository->transform_($category));
                }
                $paged_data['data'] = $res;
                $http_resp['results'] = $paged_data;
                break;
            case "Brand Sector":
            case "UOM":
            case "Sub Category":
                $this->model = new ModelRepository(new ProductCategory());
                $parentPractice = $this->practice->findParent($practice);
                $categories = $this->model->search($request->all(),$type, $parentPractice);
                $res = array();
                $paged_data = $this->helper->paginator($categories);
                foreach ($categories as $category){
                    array_push($res, $this->productRepository->transform_($category));
                }
                $paged_data['data'] = $res;
                $http_resp['results'] = $paged_data;
                break;
            case "practice_product_item":
                $this->model = new ModelRepository(new Practice());
                $items = $this->model->search($request->all(),$type);
                $productRepo = new ProductReposity(new PracticeProductItem());
                $res = array();
                foreach ($items as $item){
                    $prod_item = PracticeProductItem::find($item->id);
                    $itema = $this->helper->create_product_attribute($prod_item,"Low");
                    //$itema['stock_total'] = $itema['stock'];
                    if( $request->exists('search_type') && $request->search_type == "Batched Product Item"){
                        $itema['batched_stock'] = $productRepo->transform_product_item($prod_item,null,$practice,null);
                        array_push($res, $itema);
                    }else{
                        array_push($res, $productRepo->transform_product_item($prod_item));
                    }
                }
                $http_resp['results'] = $res;
                break;
        }
        return response()->json($http_resp);
    }

}

<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductAsset;
use App\Models\Product\ProductItem;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductItemAssetsController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $productAssets;
    protected $practice;
    protected $productItems;

    public function __construct(ProductAsset $productAssets)
    {
        $this->productAssets = $productAssets;
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practice = new PracticeRepository(new Practice());
        $this->productItems = new ProductReposity( new ProductItem() );
    }

    public function create(Request $request){

        //Log::info($request);
        $http_resp = $this->response_type['200'];
        $company = $this->practice->find($request->user()->company_id);
        $validation = Validator::make($request->all(),[
            'product_item_id' => 'required',
            'file' => 'required',
        ],$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try {
            $product_item = $this->productItems->findByUuid($request->product_item_id);
            $doc_tmp_name = $_FILES['file']['tmp_name'];
            $root_directory_array = $this->helper->create_upload_directory($company->uuid,'Product Item',$product_item->uuid);
            $newFilePath = $root_directory_array['file_server_root'].'/'.$_FILES['file']['name'];
            $file_path = $root_directory_array['file_public_access'].'/'.$_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $inputs['file_name'] = $file_name;
            $inputs['file_path'] = $file_path;
            $inputs['file_mime'] = $file_type;
            $inputs['file_size'] = round(($file_size/1000000),2).'MB';
            if(move_uploaded_file($doc_tmp_name, $newFilePath)){
                $product_item->assets()->create($inputs);
                $http_resp['description'] = "Request was successful!";
            }
        }catch (\Exception $e){
            Log::info($e);
            $http_resp = $this->response_type['500'];
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function delete(Request $request,$uuid){}
}

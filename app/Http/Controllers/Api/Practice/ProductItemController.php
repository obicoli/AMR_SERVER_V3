<?php

namespace App\Http\Controllers\Api\Practice;

use App\helpers\HelperFunctions;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeProductItemStock;
use App\Models\Product\Product;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCurrency;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Repositories\Manufacturer\ManufacturerRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Hospital\Hospital;

class ProductItemController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $practiceProductItem;
    protected $product;
    protected $generic;
    protected $manufacturer;
    protected $item_type;
    protected $brands;
    protected $item_category;
    protected $unit_measure;
    protected $practice;
    protected $product_routes;
    protected $product_currency;

    public function __construct(PracticeProductItem $practiceProductItem)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->practiceProductItem = new ProductReposity($practiceProductItem);
        $this->product = new ProductReposity(new Product());
        $this->generic = new ProductReposity(new ProductGeneric());
        $this->manufacturer = new ManufacturerRepository(new Manufacturer());
        $this->item_type = new ProductReposity(new ProductType());
        $this->brands = new ProductReposity(new ProductBrand());
        $this->item_category = new ProductReposity(new ProductCategory());
        $this->unit_measure = new ProductReposity(new ProductUnit());
        $this->practice = new PracticeRepository(new Practice());
        $this->product_routes = new ProductReposity(new ProductAdministrationRoute());
        $this->product_currency = new ProductReposity(new ProductCurrency());
    }

    public function index(){
        
    }

    public function practice($practice_id){

        $http_resp = $this->response_type['200'];
        $http_resp['results'] = [];
        return response()->json($http_resp);
    }

    public function upload(Request $request){

        $http_resp = $this->response_type['200'];

        $rules = [
            'file' => 'required',
            'practice_id' => 'required',
        ];
        
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        DB::beginTransaction();
        try{
            if(in_array($_FILES['file']['type'],$mimes)){

                $items_upload = $_FILES['file']['tmp_name'];
                $items = array();
                $data = array();
                $handle = fopen($items_upload, "r");
                while(($filesop = fgetcsv($handle, 1000, ",")) !== false){

                    $numcols = count($filesop);
                    if($numcols == 20){

                        $item_name = $filesop[0];
                        $item_generic = $filesop[1];
                        $item_sku = $filesop[2];
                        $item_bar_code = $filesop[3];
                        $item_category = $filesop[4];
                        $item_mfg = $filesop[5];
                        $item_type = $filesop[6];
                        $item_brand = $filesop[7];
                        $item_sector = $filesop[8];
                        $item_unit = $filesop[9];
                        $item_unit_sympol = $filesop[10];
                        $item_weight = $filesop[11];
                        $item_pack_qty = $filesop[12];
                        $item_ord_lvl = $filesop[13];
                        $item_unit_cost = $filesop[14];
                        $item_retail = $filesop[15];
                        $item_pack_cost = $filesop[16];
                        $item_pack_retail = $filesop[17];
                        $item_tax_name = $filesop[18];
                        $item_tax_value = $filesop[19];

                        $data['item_name'] = $item_name;
                        $data['generic_name'] = $item_generic;
                        $data['item_code'] = $item_sku;
                        $data['barcode'] = $item_bar_code;
                        $data['item_category'] = $item_category;
                        $data['manufacturer'] = $item_mfg;
                        $data['product_brand'] = $item_brand;
                        $data['brand_sector'] = $item_sector;
                        $data['product_unit'] = $item_unit;
                        $data['item_unit_sympol'] = $item_unit_sympol;
                        $data['unit_cost'] = $item_unit_cost;
                        $data['unit_retail_price'] = $item_retail;
                        $data['pack_cost'] = $item_pack_cost;
                        $data['pack_retail_price'] = $item_pack_retail;

                        $data['item_tax_name'] = $item_tax_name;
                        $data['item_tax_value'] = $item_tax_value;
                        $data['units_per_pack'] = $item_pack_qty;
                        $data['alert_indicator_level'] = $item_ord_lvl;
                        $data['single_unit_weight'] = $item_weight;
                        $data['product_type'] = $item_type;
                        $data['product_category'] = "";
                        $data['product_route'] = "";
                        $data['unit_storage_location'] = "";
                        $data['item_note'] = "";
                        $data['net_weight'] = "";
                        $data['item_stock'] = "";
                        $data['item_currency'] = "";
                        $data['product_unit_slug'] = $item_unit;

                        array_push($items, $data);


                    }else{
                        DB::rollBack();
                        $http_resp = $this->response_type['422'];
                        $http_resp['errors'] = ['Please check your file format to continue'];
                        return response()->json($http_resp,422);
                    }

                }

                $http_resp['results'] = $items;

                $http_resp['description'] = "Successful!";

            }else{
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['File must be a CSV'];
                return response()->json($http_resp,422);
            }
        }catch (\Exception $exception){
            Log::info($exception);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function create(Request $request){

        $http_resp = $this->response_type['200'];

        $rule1 = [
            'upload_type' => 'required|in:Bulk,Single',
        ];

        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        if($request->upload_type == "Single"){
            $validation = Validator::make($request->all(),$this->helper->product_rule(), $this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }else{
            $validation = Validator::make($request->all(),['items'=>'required'], $this->helper->messages());
            if ($validation->fails()){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }



        DB::beginTransaction();
        try{
            
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice_main = $this->practice->findOwner($practice);
            $parent_practice = $this->practice->findParent($practice_main);
            //get product by name
            $inpo = $request->all();
            $inpo['practice_id'] = $practice_main->id;
            $inpo['name'] = $request->item_name;
            $product = $this->practice->setProduct($parent_practice, $inpo);
            //get generic by name
            $inpo['name'] = $request->generic_name;
            $generics = $this->practice->setGeneric($parent_practice,$inpo);
            //find manufacturere by name
            $inpo['name'] = $request->manufacturer;
            $manufacturer = $this->manufacturer->store($inpo);
            //set brand name
            //$item_type = $this->item_type->findByName($request->item_type);
            $inpo['name'] = $request->item_type;
            $item_type = $this->practice->setProductType($parent_practice,$inpo);
            $inpo['name'] = $request->brand_name;
            $brand = $this->practice->setBrand($parent_practice,$inpo);
            $inpo['name'] = $request->brand_sector;
            $brand_sect = $this->practice->setBrandSector($parent_practice,$inpo);
            $inpo['name'] = $request->item_category;
            $category = $this->practice->setCategory($parent_practice,$inpo);
            $item_array = explode(" ", $request->unit_measure);
            $units = $this->unit_measure->findByUuid($request->unit_measure);
            $currency = $this->product_currency->findByUuid($request->product_currency_id);
            if ($this->practiceProductItem->findByCode($practice,$request->item_code)){
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Item code already taken'];
                return response()->json($http_resp,422);
            }
            $inputs = $request->except(['item_name','generic_name','manufacturer','item_type','brand_name','item_category','unit_measure','practice_id']);

            $inputs['practice_id'] = $practice->id;
            $inputs['product_id'] = $product->id;
            $inputs['generic_id'] = $generics->id;
            $inputs['manufacturer_id'] = $manufacturer->id;
            $inputs['product_type_id'] = $item_type->id;
            if ($category){
                $inputs['product_category_id'] = $category->id;
            }

            $inputs['product_unit_id'] = $units->id;
            $inputs['product_brand_id'] = $brand->id; //product_brand_sector_id
            $inputs['product_brand_sector_id'] = $brand_sect->id; //
            $inputs['product_currency_id'] = $currency->id;
            $new_item = $this->practiceProductItem->setProductItem($inputs);

            $prices = [
                'practice_id' => $practice->id,
                'practice_product_item_id' => $new_item->id,
                'unit_cost' => $request->unit_cost,
                'unit_retail_price' => $request->unit_retail_price,
                'pack_cost' => $request->pack_cost,
                'pack_retail_price' => $request->pack_retail_price,
            ];

            $prc = $this->practiceProductItem->setProductItemPrice($new_item, $prices);
            if( is_array($request->tax_per_unit) && sizeof($request->tax_per_unit)>0 ){
            }
            $http_resp['description'] = "Product item successful created!";

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function show($uuid){}
    public function destroy($uuid){

        $http_resp = $this->response_type['200'];
        try{

            $productItem = $this->practiceProductItem->findByUuid($uuid);
            $this->practiceProductItem->destroy($productItem->id);
            $http_resp['description'] = "Product Item deleted successful!";

        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        //Log::info($request);
        $rules = [
            'item_name' => 'required',
            'generic_name' => 'required',
            'manufacturer' => 'required',
            'item_code' => 'required',
            'item_type' => 'required',
            'barcode' => 'required',
            'item_note' => 'required',
            'brand_name' => 'required',
            'unit_measure' => 'required',
            'single_unit_weight' => 'required',
            'net_weight' => 'required',
            'alert_indicator_level' => 'required',
            'units_per_pack' => 'required',
            //'tax_per_unit' => 'required',
            'unit_storage_location' => 'required',
            'practice_id' => 'required',
            'product_currency_id' => 'required',
        ];

        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();
        try{
            $practice = $this->practice->findByUuid($request->practice_id);
            $practice_main = $this->practice->findOwner($practice);
            //get product by name
            $inpo = $request->all();
            $inpo['practice_id'] = $practice_main->id;
            $inpo['name'] = $request->item_name;
            $product = $this->practice->setProduct($practice_main, $inpo);
            //get generic by name
            $inpo['name'] = $request->generic_name;
            //$generics = $this->generic->findByName($request->generic_name); //generic_name
            $generics = $this->practice->setGeneric($practice_main,$inpo);
            //find manufacturere by name
            //$manufacturer = $this->manufacturer->findByName($request->manufacturer);
            $inpo['name'] = $request->manufacturer;
            $manufacturer = $this->manufacturer->store($inpo);
            $item_type = $this->item_type->findByName($request->item_type);
            //$brand = $this->brands->findByName($request->brand_name);
            $inpo['name'] = $request->brand_name;
            $brand = $this->practice->setBrand($practice_main,$inpo);
            $inpo['name'] = $request->brand_sector;
            $brand_sect = $this->practice->setBrandSector($practice_main,$inpo);
            //$category = $this->item_category->findByName($request->item_category);
            // $inpo['name'] = $request->
            $inpo['name'] = $request->item_category;
            $category = $this->practice->setCategory($practice_main,$inpo);
            $item_array = explode(" ", $request->unit_measure);
            //$units = $this->unit_measure->findByName($item_array[0]);//unit_measure
            $units = $this->unit_measure->findByUuid($request->unit_measure);
            //$routesy = $this->product_routes->findByName($request->product_routes_name);
            // $inpo['name'] = $request->product_routes_name;
            // $routesy = $this->practice->setProductRoute($practice_main,$inpo);
            $currency = $this->product_currency->findByUuid($request->product_currency_id);

            if ($this->practiceProductItem->findByCode($practice,$request->item_code)){
                DB::rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ['Item code already taken'];
                return response()->json($http_resp,422);
            }
            $inputs = $request->except(['item_name','generic_name','manufacturer','item_type','brand_name','item_category','unit_measure','practice_id']);

            $inputs['practice_id'] = $practice->id;
            $inputs['product_id'] = $product->id;
            $inputs['generic_id'] = $generics->id;
            $inputs['manufacturer_id'] = $manufacturer->id;
            $inputs['product_type_id'] = $item_type->id;
            if ($category){
                $inputs['product_category_id'] = $category->id;
            }

            $inputs['product_unit_id'] = $units->id;
            $inputs['product_brand_id'] = $brand->id; //product_brand_sector_id
            $inputs['product_brand_sector_id'] = $brand_sect->id; //
            $inputs['product_currency_id'] = $currency->id;
            $new_item = $this->practiceProductItem->setProductItem($inputs);
            $prices = [
                'practice_id' => $practice->id,
                'practice_product_item_id' => $new_item->id,
                'unit_cost' => $request->unit_cost,
                'unit_retail_price' => $request->unit_retail_price,
                'pack_cost' => $request->pack_cost,
                'pack_retail_price' => $request->pack_retail_price,
            ];

            // $inpo['name'] = $request->item_name;
            // if( $this->product->checkExistence($inpo) ){
            //     DB::rollBack();
            //     $http_resp = $this->response_type['422'];
            //     $http_resp['errors'] = ['Product name already in use'];
            //     return response()->json($http_resp,422);
            // }

            $prc = $this->practiceProductItem->setProductItemPrice($new_item, $prices);
            if( is_array($request->tax_per_unit) && sizeof($request->tax_per_unit)>0 ){
                Log::info($request->tax_per_unit);
            }
            //$stok = new PracticeProductItemStock();
            //$stok->practice_id = $practice->id;
            //$new_item->stocks()->save($stok);
            $http_resp['description'] = "Product item successful updated!";

        }catch (\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

}

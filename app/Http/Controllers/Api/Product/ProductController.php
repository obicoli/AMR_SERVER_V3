<?php

namespace App\Http\Controllers\Api\Product;

use App\helpers\HelperFunctions;
use App\Manufacturer\Repository\ManufacturerRepository;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Product;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\Route\ProductRoutes;
// use App\Models\Product\ProductCurrency;
//use App\Repositories\Manufacturer\ManufacturerRepository;
use \App\Manufacturer\Models\Manufacturer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\PractProdSaleCharge;
use App\Models\Product\ProductSalesCharge;

class ProductController extends Controller
{
    protected $product;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $productItem;

    protected $practiceProductItem;
    protected $generic;
    protected $item_type;
    protected $brands;
    protected $item_category;
    protected $unit_measure;
    protected $product_routes;
    protected $manufacturers;

    public function __construct(Product $product)
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->product = new ProductReposity($product);
        $this->practice = new PracticeRepository(new Practice());
        $this->productItem = new ProductReposity(new PracticeProductItem());
        $this->practiceProductItem = new ProductReposity(new PracticeProductItem());
        $this->generic = new ProductReposity(new ProductGeneric());
        //$this->manufacturers = new ManufacturerRepository(new Manufacturer());
        $this->manufacturers = new ManufacturerRepository( new Manufacturer() );
        $this->item_type = new ProductReposity(new ProductType());
        $this->brands = new ProductReposity(new ProductBrand());
        $this->item_category = new ProductReposity(new ProductCategory());
        $this->unit_measure = new ProductReposity(new ProductUnit());
        $this->practice = new PracticeRepository(new Practice());
        $this->product_routes = new ProductReposity(new ProductRoutes());
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practice->find($request->user()->company_id);
        $headQuarter = $this->practice->findParent($company);
        $results = array();
        if($request->has('attributes')){

            $results['brands'] = [];
            $brands = $headQuarter->product_brands()->get();
            foreach ($brands as $brand){
                array_push($results['brands'],$this->product->transform_attribute($brand));
            }

            $results['brand_sectors'] = [];
            $brand_sectors = $headQuarter->product_brand_sector()->get();
            foreach ($brand_sectors as $brand_sector){
                array_push($results['brand_sectors'],$this->product->transform_attribute($brand_sector));
            }
            //
            $results['manufacturers'] = [];
            $manufacturers = $this->manufacturers->all();
            foreach ($manufacturers as $manufacturer){
                $temp_data['id'] = $manufacturer->uuid;
                $temp_data['name'] = $manufacturer->name;
                array_push($results['manufacturers'],$temp_data);
            }
            //
            $unitsofmeasures = $headQuarter->product_units()->get();
            $results['unitsofmeasure'] = [];
            foreach ($unitsofmeasures as $unitsofmeasure){
                array_push($results['unitsofmeasure'],$this->product->transform_unit($unitsofmeasure));
            }
            //
            $generics = $headQuarter->generics()->get();
            $results['generics'] = [];
            foreach ($generics as $generic){
                array_push($results['generics'],$this->product->transform_attribute($generic));
            }

            $results['profiles'] = [];
            $product_profiles = $headQuarter->product_profiles()->get();
            $results['profiles'] = [];
            foreach ($product_profiles as $product_profile){
                array_push($results['profiles'],$this->product->transform_attribute($product_profile));
            }

            $results['item_types'] = [];
            $item_types = $headQuarter->product_type()->get();
            $results['item_types'] = [];
            foreach ($item_types as $item_type){
                array_push($results['item_types'],$this->product->transform_attribute($item_type));
            }

            $results['categories'] = [];
            $product_category = $headQuarter->product_category()->get();
            foreach ($product_category as $product_categ){
                array_push($results['categories'],$this->product->transform_attribute($product_categ));
            }

            $results['order_categories'] = [];
            $order_categories = $headQuarter->product_order_category()->get();
            foreach ($order_categories as $order_categorie){
                array_push($results['order_categories'],$this->product->transform_attribute($order_categorie));
            }

            $results['sub_categories'] = [];
            $sub_categories = $headQuarter->product_sub_category()->get();
            foreach ($sub_categories as $sub_category){
                array_push($results['sub_categories'],$this->product->transform_attribute($sub_category));
            }

            $results['product_routes'] = [];
            $product_routes = $headQuarter->product_routes()->get();
            foreach ($product_routes as $product_route){
                array_push($results['product_routes'],$this->product->transform_attribute($product_route));
            }

            $results['formulations'] = [];
            $formulations = $headQuarter->product_formulations()->get();
            foreach ($formulations as $formulation){
                array_push($results['formulations'],$this->product->transform_attribute($formulation));
            }

            $results['suppliers'] = [];

        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

//    public function attributes(Request $request){
//        $http_resp = $this->http_response['200'];
//        $practice = $this->practice->find($request->user()->company_id);
//        Log::info($practice);
//        $http_resp['results'] = $this->product->getAttributes($practice);
//        return response()->json($http_resp);
//    }
//
//    public function practice($practice_uuid){
//
//        $http_resp = $this->http_response['200'];
//        $results = array();
//        $practice = $this->practice->findByUuid($practice_uuid);
//        $products = $this->productItem->getProductItem($practice);
//        foreach ($products as $item) {
//            //array_push($results, $this->productItem->transform_product_item($item) );
//            array_push($results, $this->helper->create_product_attribute($item,"Low") );
//        }
//
//        $response = [
//            'pagination' => [
//                'total' => $products->total(),
//                'per_page' => $products->perPage(),
//                'current_page' => $products->currentPage(),
//                'last_page' => $products->lastPage(),
//                'from' => $products->firstItem(),
//                'to' => $products->lastItem()
//            ],
//            'data' => $results
//        ];
//
//        $http_resp['results'] = $response;
//        return response()->json($http_resp);
//    }

//    public function store(Request $request){
//
//        $http_resp = $this->http_response['200'];
//
//        $rule1 = [
//            'upload_type' => 'required|in:Bulk,Single',
//        ];
//
//        $validation = Validator::make($request->all(),$rule1, $this->helper->messages());
//        if ($validation->fails()){
//            $http_resp = $this->http_response['422'];
//            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
//            return response()->json($http_resp,422);
//        }
//
//        if($request->upload_type == "Single"){
//            $validation = Validator::make($request->all(),$this->helper->product_rule(), $this->helper->messages());
//            if ($validation->fails()){
//                $http_resp = $this->http_response['422'];
//                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
//                return response()->json($http_resp,422);
//            }
//        }else{
//            $validation = Validator::make($request->all(),['items'=>'required'], $this->helper->messages());
//            if ($validation->fails()){
//                $http_resp = $this->http_response['422'];
//                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
//                return response()->json($http_resp,422);
//            }
//        }
//
//        DB::beginTransaction();
//        try{
//
//            $practice = $this->practice->findByUuid($request->practice_id);
//            $practice_main = $this->practice->findOwner($practice);
//            $parent_practice = $this->practice->findParent($practice_main);
//
//            if($request->upload_type == "Single"){
//
//                //get product by name
//                $inpo = $request->all();
//                //$inpo['practice_id'] = $practice_main->id;
//                $inpo['name'] = $request->item_name;
//                $product = $this->practice->setProduct($parent_practice, $inpo);
//                //get generic by name
//                $inpo['name'] = $request->generic_name;
//                $generics = $this->practice->setGeneric($parent_practice,$inpo);
//                //find manufacturere by name
//                $inpo['name'] = $request->manufacturer;
//                $manufacturer = $this->manufacturer->store($inpo);
//                //set brand name
//                //$item_type = $this->item_type->findByName($request->item_type);
//                $inpo['name'] = $request->item_type;
//                $item_type = $this->practice->setProductType($parent_practice,$inpo);
//                $inpo['name'] = $request->brand_name;
//                $brand = $this->practice->setBrand($parent_practice,$inpo);
//                $inpo['name'] = $request->brand_sector;
//                $brand_sect = $this->practice->setBrandSector($parent_practice,$inpo);
//                $inpo['name'] = $request->item_category;
//                $category = $this->practice->setCategory($parent_practice,$inpo);
//                //$item_array = explode(" ", $request->unit_measure);
//                $inpo['name'] = $request->unit_measure;
//                $units = $this->practice->setUnits($parent_practice,$inpo);
//                //$currency = $this->product_currency->findByUuid($request->product_currency_id);
//                if ($this->practiceProductItem->findByCode($parent_practice,$request->item_code)){
//                    DB::rollBack();
//                    $http_resp = $this->http_response['422'];
//                    $http_resp['errors'] = ['Item code already taken'];
//                    return response()->json($http_resp,422);
//                }
//                $inputs = $request->except(['item_name','generic_name','manufacturer','item_type','brand_name','item_category','unit_measure','practice_id']);
//                //$inputs['practice_id'] = $practice->id;
//                $inputs['product_id'] = $product->id;
//                $inputs['generic_id'] = $generics->id;
//                $inputs['manufacturer_id'] = $manufacturer->id;
//                $inputs['product_type_id'] = $item_type->id;
//                if ($category){
//                    $inputs['product_category_id'] = $category->id;
//                }
//                $inputs['product_unit_id'] = $units->id;
//                $inputs['product_brand_id'] = $brand->id; //product_brand_sector_id
//                $inputs['product_brand_sector_id'] = $brand_sect->id; //
//                //$inputs['product_currency_id'] = $currency->id;
//                $new_item = $this->practiceProductItem->setProductItem($parent_practice,$inputs);
//                $prices = [
//                    'practice_id' => $practice->id,
//                    'practice_product_item_id' => $new_item->id,
//                    'unit_cost' => $request->unit_cost,
//                    'unit_retail_price' => $request->unit_retail_price,
//                    'pack_cost' => $request->pack_cost,
//                    'pack_retail_price' => $request->pack_retail_price,
//                ];
//
//                $prc = $this->practiceProductItem->setProductItemPrice($new_item, $prices);
//                if( is_array($request->tax_per_unit) && sizeof($request->tax_per_unit)>0 ){
//                    for( $l=0; $l<sizeof($request->tax_per_unit); $l++ ){
//                        //$inpo['name'] = $request->tax_per_unit[$l]->tax_per_unit;
//                        $tax = ProductSalesCharge::all()->where('uuid',$request->tax_per_unit[$l])->first();
//                        //$tax = $this->practice->setTax($parent_practice,$inpo);
//                        $inpo['product_sales_charge_id'] = $tax->id;
//                        $inpo['practice_product_item_id'] = $new_item->id;
//                        //DB::table('pract_prod_sale_charges')->create($inpo);
//                        PractProdSaleCharge::create($inpo);
//                    }
//                }
//                $http_resp['description'] = "Product item successful created!";
//
//            }else{
//                //Bulk upload
//                $data = json_decode($request->items);
//                //Log::info($data);
//                for( $k=0; $k < sizeof($data); $k++){
//
//                    //get product by name
//                    $inpo = $request->all();
//                    $inpo['name'] = $data[$k]->item_name;
//                    $product = $this->practice->setProduct($parent_practice, $inpo);
//
//                    //get generic by name
//                    //$inpo['name'] = $request->generic_name;
//                    $inpo['name'] = $data[$k]->generic_name;
//                    $generics = $this->practice->setGeneric($parent_practice,$inpo);
//                    //find manufacturere by name
//                    //$inpo['name'] = $request->manufacturer;
//                    $inpo['name'] = $data[$k]->manufacturer;
//                    $manufacturer = $this->manufacturer->store($inpo);
//                    //set brand name
//                    //$item_type = $this->item_type->findByName($request->item_type);
//
//                    //$inpo['name'] = $request->item_type;
//                    $inpo['name'] = $data[$k]->profile_name;
//                    $item_type = $this->practice->setProductType($parent_practice,$inpo);
//
//                    //$inpo['name'] = $request->brand_name;
//                    $inpo['name'] = $data[$k]->brand;
//                    $brand = $this->practice->setBrand($parent_practice,$inpo);
//
//                    //$inpo['name'] = $request->brand_sector;
//                    $inpo['name'] = $data[$k]->brand_sector;
//                    $brand_sect = $this->practice->setBrandSector($parent_practice,$inpo);
//
//                    //$inpo['name'] = $request->item_category;
//                    $inpo['name'] = $data[$k]->category;
//                    $category = $this->practice->setCategory($parent_practice,$inpo);
//
//                    $inpo['name'] = $data[$k]->measure_unit_name;
//                    $inpo['slug'] = $data[$k]->measure_unit_symbol;
//                    $units = $this->practice->setUnits($parent_practice,$inpo);
//
//                    if ($this->practiceProductItem->findByCode($parent_practice,$request->item_code)){
//                        DB::rollBack();
//                        $http_resp = $this->http_response['422'];
//                        $http_resp['errors'] = ['Item code already taken'];
//                        return response()->json($http_resp,422);
//                    }
//
//                    $inputs = $request->except(['item_name','generic_name','manufacturer','item_type','brand_name','item_category','unit_measure','practice_id']);
//                    $inputs['product_id'] = $product->id;
//                    $inputs['generic_id'] = $generics->id;
//                    $inputs['manufacturer_id'] = $manufacturer->id;
//                    $inputs['product_type_id'] = $item_type->id;
//                    if ($category){
//                        $inputs['product_category_id'] = $category->id;
//                    }
//
//                    $inputs['product_unit_id'] = $units->id;
//                    $inputs['item_code'] = $data[$k]->sku_code;
//                    $inputs['barcode'] = $data[$k]->barcode;
//                    $inputs['single_unit_weight'] = $data[$k]->unit_weight;
//                    $inputs['units_per_pack'] = $data[$k]->pack_qty;
//                    $inputs['alert_indicator_level'] = $data[$k]->reorder_level;
//                    $inputs['net_weight'] = $data[$k]->unit_weight * $data[$k]->pack_qty;
//                    $inputs['product_brand_id'] = $brand->id;
//                    $inputs['product_brand_sector_id'] = $brand_sect->id;
//                    //$inputs['product_currency_id'] = $currency->id;
//                    $new_item = $this->practiceProductItem->setProductItem($parent_practice, $inputs);
//                    $prices = [
//                        'practice_product_item_id' => $new_item->id,
//                        'practice_id' => $practice->id,
//                        'unit_cost' => $data[$k]->unit_cost,
//                        'unit_retail_price' => $data[$k]->unit_retail,
//                        'pack_cost' => $data[$k]->pack_cost,
//                        'pack_retail_price' => $data[$k]->pack_retail,
//                    ];
//                    $prc = $this->practiceProductItem->setProductItemPrice($new_item, $prices);
//                    if( $data[$k]->tax_name != "" && $data[$k]->tax_value != "" ){
//                        $inpo['name'] = $data[$k]->tax_name;
//                        $inpo['amount'] = $data[$k]->tax_value;
//                        $tax = $this->practice->setTax($parent_practice,$inpo);
//                        $inpo['product_sales_charge_id'] = $tax->id;
//                        $inpo['practice_product_item_id'] = $new_item->id;
//                        //DB::table('pract_prod_sale_charges')->create($inpo);
//                        PractProdSaleCharge::create($inpo);
//                    }
//                    $http_resp['description'] = "Products uploaded successful!";
//
//                }
//
//            }
//        }catch (\Exception $e){
//            Log::info($e);
//            DB::rollBack();
//            $http_resp = $this->http_response['500'];
//            return response()->json($http_resp,500);
//        }
//        DB::commit();
//        return response()->json($http_resp);
//
//    }



    public function update(Request $request,$uuid){
        $http_resp = $this->http_response['200'];
        return response()->json($http_resp);
    }

//    public function show($uuid,$practice_uuid=null){
//        $http_resp = $this->http_response['200'];
//        if($practice_uuid){
//            $practice = $this->practice->findByUuid($practice_uuid);
//            $product = $this->productItem->findByUuid($uuid);
//            $http_resp['results'] = $this->productItem->transform_product_item($product,null,$practice,null);
//        }else{
//            $product = $this->productItem->findByUuid($uuid);
//            $http_resp['results'] = $this->productItem->transform_product_item($product);
//        }
//        return response()->json($http_resp);
//    }

//    public function barcode($facility_id,$barcode){
//        $http_resp = $this->http_response['200'];
//        $practice = $this->practice->findByUuid($facility_id);
//        $parentPractice = $this->practice->findParent($practice);
//        $product = $parentPractice->product_items()->get()->where('barcode',$barcode)->first();
//        if($product){
//            $http_resp['results'] = $this->productItem->transform_product_item($product,null,null,null);
//        }else {
//            $http_resp['results'] = [];
//        }
//        return response()->json($http_resp);
//    }

//    public function stocks($facility_id){
//
//        $http_resp = $this->http_response['200'];
//        $practice = $this->practice->findByUuid($facility_id);
//        $parentPractice = $this->practice->findParent($practice);
//        $products = $parentPractice->product_items()->get();
//
//        $data['id'] =
//        $results = array();
//        foreach ($products as $item) {
//            array_push($results, $this->productItem->transform_product_item($item));
//        }
//        $http_resp['results']=$results;
//        return response()->json($http_resp);
//
//    }

    public function destroy($uuid){}

    // public function upload(Request $request){

    //     $http_resp = $this->http_response['200'];
    //     //Log::info($request);
    //     $rules = [
    //         'file' => 'required',
    //         'practice_id' => 'required',
    //         'upload_type' => 'required',
    //     ];
        
    //     $validation = Validator::make($request->all(),$rules, $this->helper->messages());
    //     if ($validation->fails()){
    //         $http_resp = $this->http_response['422'];
    //         $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
    //         return response()->json($http_resp,422);
    //     }

    //     $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    //     DB::beginTransaction();
    //     try{
    //         if(in_array($_FILES['file']['type'],$mimes)){

    //             $items_upload = $_FILES['file']['tmp_name'];
    //             $items = array();
    //             $data = array();
    //             $handle = fopen($items_upload, "r");
    //             $index = 0;
    //             while(($filesop = fgetcsv($handle, 1000, ",")) !== false){

    //                 $numcols = count($filesop);
    //                 if($numcols == 21 && $request->upload_type =="Products"){

    //                     $data = $this->helper->create_product_attribute();
                        // $data['item_name'] = $filesop[0];
                        // $data['generic_name'] = $filesop[1];
                        // $data['sku_code'] = $filesop[2];
                        // $data['barcode'] = $filesop[3];
                        // $data['category'] = $filesop[4];
                        // $data['manufacturer'] = $filesop[5];
                        // $data['profile_name'] = $filesop[6];
                        // $data['brand'] = $filesop[7];
                        // $data['brand_sector'] = $filesop[8];
                        // $data['measure_unit_name'] = $filesop[9];
                        // $data['measure_unit_symbol'] = $filesop[10];
                        // $data['unit_weight'] = $filesop[11];
                        // $data['pack_qty'] = $filesop[12];
                        // $data['reorder_level'] = $filesop[13];
                        // $data['unit_cost'] = $filesop[14];
                        // $data['unit_retail'] = $filesop[15];
                        // $data['pack_cost'] = $filesop[16];
                        // $data['pack_retail'] = $filesop[17];
                        // $data['tax_name'] = $filesop[18];
                        // $data['tax_value'] = $filesop[19];
                        // $data['note'] = $filesop[20];

                        // $data['product_category'] = "";
                        // $data['product_route'] = "";
                        // $data['unit_storage_location'] = "";
                        // $data['item_note'] = "";
                        // $data['net_weight'] = "";
                        // $data['item_stock'] = "";
                        // $data['item_currency'] = "";

    //                     array_push($items, $data);


    //                 }elseif($numcols == 14 && $request->upload_type =="Suppliers"){

    //                     $practice = $this->practice->findByUuid($request->practice_id);
    //                     $parentPractice = $this->practice->findParent($practice);
    //                     $data['title'] = $filesop[0];
    //                     $data['first_name'] = $filesop[1];
    //                     $data['middle_name'] = $filesop[2];
    //                     $data['other_name'] = $filesop[3];
    //                     $data['company'] = $filesop[4];
    //                     $data['address'] = $filesop[5];
    //                     $data['city'] = $filesop[6];
    //                     $data['country'] = $filesop[7];
    //                     $data['postal_code'] = $filesop[8];
    //                     $data['note'] = $filesop[9];
    //                     $data['email'] = $filesop[10];
    //                     $data['phone'] = $filesop[11];
    //                     $data['mobile'] = $filesop[12];
    //                     $data['fax'] = $filesop[13];
    //                     if($index > 0){
    //                         $vendor = $parentPractice->vendors()->create($data);
    //                         $vendor = $practice->vendors()->save($vendor);
    //                     }
    //                     $index += 1;
    //                 }
    //                 else{
    //                     DB::rollBack();
    //                     $http_resp = $this->http_response['422'];
    //                     $http_resp['errors'] = ['Please check your file format to continue'];
    //                     return response()->json($http_resp,422);
    //                 }
    //             }
    //             $http_resp['results'] = $items;
    //             //Log::info($items);
    //             $http_resp['description'] = "Successful!";
    //         }else{
    //             DB::rollBack();
    //             $http_resp = $this->http_response['422'];
    //             $http_resp['errors'] = ['File must be a CSV'];
    //             return response()->json($http_resp,422);
    //         }
    //     }catch (\Exception $exception){
    //         Log::info($exception);
    //         DB::rollBack();
    //         $http_resp = $this->http_response['500'];
    //         return response()->json($http_resp,500);
    //     }
    //     DB::commit();
    //     return response()->json($http_resp);
    // }

}

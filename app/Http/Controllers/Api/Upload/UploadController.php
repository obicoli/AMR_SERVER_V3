<?php

namespace App\Http\Controllers\Api\Upload;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Product;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account\Vendors\AccountVendor;
use Illuminate\Support\Facades\Config;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductUnit;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductCurrency;
use App\Repositories\Manufacturer\ManufacturerRepository;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Product\ProductItem;
use App\Models\Product\Profile\ProductProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    // protected $product;
    protected $http_response;
    protected $helper;
    protected $practice;
    protected $company;
    protected $accountSuppliers;
    protected $productItems;
    protected $manufacturers;
    protected $productProfiles;
    protected $productTypes;
    protected $productUnits;
    protected $products;
    protected $practiceProductItem;
    // protected $practiceProductItem;
    // protected $generic;
    // protected $manufacturer;
    // protected $item_type;
    // protected $brands;
    // protected $item_category;
    // protected $unit_measure;
    // protected $product_routes;
    // protected $product_currency;

    public function __construct()
    {
        $this->http_response = Config::get('response.http');
        $this->helper = new HelperFunctions();
        // $this->product = new ProductReposity($product);
        $this->practice = new PracticeRepository(new Practice());
        $this->company = new ProductReposity(new Manufacturer());
        $this->accountSupplier = new ProductReposity(new AccountVendor());
        $this->productItem = new ProductReposity( new ProductItem());
        $this->manufacturer = new ManufacturerRepository(new Manufacturer());
        $this->productTypes = new ProductReposity( new ProductType() );
        $this->productProfiles = new ProductReposity( new ProductProfile() );
        $this->products = new ProductReposity( new Product() );
        $this->productUnits = new ProductReposity( new ProductUnit() );
        // $this->productItem = new ProductReposity(new PracticeProductItem());
        // $this->http_response = Config::get('response.http');
        // $this->helper = new HelperFunctions();
        $this->practiceProductItem = new ProductReposity(new PracticeProductItem());
        // $this->product = new ProductReposity(new Product());
        // $this->generic = new ProductReposity(new ProductGeneric());
        // $this->manufacturer = new ManufacturerRepository(new Manufacturer());
        // $this->item_type = new ProductReposity(new ProductType());
        // $this->brands = new ProductReposity(new ProductBrand());
        // $this->item_category = new ProductReposity(new ProductCategory());
        // $this->unit_measure = new ProductReposity(new ProductUnit());
        // $this->practice = new PracticeRepository(new Practice());
        // $this->product_routes = new ProductReposity(new ProductAdministrationRoute());
        // $this->product_currency = new ProductReposity(new ProductCurrency());
    }

    public function store_upload(Practice $practice, $items, $upload_type){

        // Log::info($request);
        // $http_resp = $this->http_response['200'];
        // $rules = [
        //     'items' => 'required',
        //     'practice_id' => 'required',
        //     'upload_type' => 'required',
        // ];
        // $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        // if ($validation->fails()){
        //     $http_resp = $this->http_response['422'];
        //     $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
        //     return response()->json($http_resp,422);
        // }

        //DB::beginTransaction();
        try{
            //$practice = $this->practice->findByUuid($request->practice_id);
            $practiceParent = $this->practice->findParent($practice);
            $results = array();
            switch($upload_type){
                case "Category": //Categories
                    for( $k=0; $k < sizeof($items); $k++ ){
                        $temp_data['name'] = $items[$k]['name'];
                        $temp_data['description'] = $items[$k]['description'];
                        //array_push($results,$te_item);
                        if($k > 0){
                            $category = $practiceParent->product_category()->where('name',$temp_data['name'])->get()->first();
                            if($category){
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Category name name already in use";
                            }else{
                                $category = $practiceParent->product_category()->create($temp_data);
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                            }
                        }
                        array_push($results,$temp_data);
                    }
                break;
                case "Sub Category":
                    for( $k=0; $k < sizeof($items); $k++ ){
                        $temp_data['name'] = $items[$k]['name'];
                        $temp_data['description'] = $items[$k]['description'];
                        //array_push($results,$te_item);
                        if($k > 0){
                            $category = $practiceParent->product_sub_category()->where('name',$temp_data['name'])->get()->first();
                            if($category){
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Category name name already in use";
                            }else{
                                $category = $practiceParent->product_sub_category()->create($temp_data);
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                            }
                        }
                        array_push($results,$temp_data);
                    }
                break;
                case "Order Category": //Order Category
                    for( $k=0; $k < sizeof($items); $k++ ){
                        $temp_data['name'] = $items[$k]['name'];
                        $temp_data['description'] = $items[$k]['description'];
                        //array_push($results,$te_item);
                        if($k > 0){
                            $category = $practiceParent->product_order_category()->where('name',$temp_data['name'])->get()->first();
                            if($category){
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Category name name already in use";
                            }else{
                                $category = $practiceParent->product_order_category()->create($temp_data);
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                            }
                        }
                        array_push($results,$temp_data);
                    }
                break;
                case "Brands": //Brand
                    for( $k=0; $k < sizeof($items); $k++ ){
                        $temp_data['name'] = $items[$k]['name'];
                        $temp_data['company_id'] = $items[$k]['company_id'];
                        //array_push($results,$te_item);
                        if($k > 0){
                            $category = $practiceParent->product_brands()->where('name',$temp_data['name'])->get()->first();
                            if($category){
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Brand name name already in use";
                            }else{
                                $category = $practiceParent->product_brands()->create($temp_data);
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                            }
                        }
                        array_push($results,$temp_data);
                    }
                break;
                case "Brand Sector": //Brand Sector
                    for( $k=0; $k < sizeof($items); $k++ ){
                        $temp_data['name'] = $items[$k]['name'];
                        $temp_data['description'] = $items[$k]['description'];
                        //array_push($results,$te_item);
                        if($k > 0){
                            $category = $practiceParent->product_brand_sector()->where('name',$temp_data['name'])->get()->first();
                            if($category){
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Category name name already in use";
                            }else{
                                $category = $practiceParent->product_brand_sector()->create($temp_data);
                                $temp_data['id'] = $category->uuid;
                                $temp_data['name'] = $category->name;
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                            }
                        }
                        array_push($results,$temp_data);
                    }
                break;
                case "Suppliers":
                    for( $k=0; $k < sizeof($items); $k++ ){
                        if($k > 0){
                            $vendorz = $practiceParent->vendors()
                            ->where('email',$items[$k]['email'])
                            ->orWhere('mobile',$items[$k]['mobile'])
                            ->get()
                            ->first();
                            if($vendorz){
                                $temp_data['id'] = $vendorz->uuid;
                                $temp_data['name'] = $items[$k]['first_name'].' '.$items[$k]['middle_name'].' ('.$items[$k]['company'].')';
                                $temp_data['status'] = false;
                                $temp_data['description'] = "Email or mobile already in use";
                                array_push($results,$temp_data);
                            }else{
                                $vendorz = $practiceParent->vendors()->create($items[$k]);
                                $vendorz = $practice->vendors()->save($vendorz);
                                $temp_data['id'] = $vendorz->uuid;
                                $temp_data['name'] = $items[$k]['first_name'].' '.$items[$k]['middle_name'].' ('.$items[$k]['company'].')';
                                $temp_data['status'] = true;
                                $temp_data['description'] = "Created successful";
                                array_push($results,$temp_data);
                            }
                        }
                    }
                break;
            }

        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        return $results;
        
    }

    public function uploads(Request $request){

       // Log::info($request);
        $http_resp = $this->http_response['200'];
        $results = array();
        $mimes = [];
        $rules = [
            'file' => 'required',
            'practice_id' => 'required',
            'upload_type' => 'required',
        ];
        $validation = Validator::make($request->all(),$rules, $this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        $practice = $this->practice->find($request->user()->company_id);
        $practiceParent = $this->practice->findParent($practice);
        switch($request->upload_type){
            case "Category":
            case "Sub Category":
            case "Order Category":
            case "Brands":
            case "Brand Sector":
            case "Inventory Items":
            case "Suppliers":
                $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
                break;
        }


        DB::beginTransaction();
        try{
            if(in_array($_FILES['file']['type'],$mimes)){
                $items_upload = $_FILES['file']['tmp_name'];
                $items = array();
                $data = array();
                $handle = fopen($items_upload, "r");
                $index = 0;
                while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                    $numcols = count($filesop);
                    switch($request->upload_type){ //Check which upload
                        case "Category": //Uploading Categories
                        case "Sub Category":
                        case "Order Category":
                        case "Brand Sector":
                            if($numcols == 2){
                                $data['name'] = $filesop[0];
                                $data['description'] = $filesop[1];
                                array_push($items, $data);
                            }else{
                                DB::rollBack();
                                $http_resp = $this->http_response['422'];
                                $http_resp['errors'] = ['Please check sample file'];
                                return response()->json($http_resp,422);
                            }
                            break;
                        case "Brands":
                            if($numcols == 2){
                                $data['name'] = $filesop[0];
                                $company_name = $filesop[1];
                                $company = $this->company->getOrCreate($company_name);
                                $data['company_id'] = $company->id;
                                array_push($items, $data);
                            }else{
                                DB::rollBack();
                                $http_resp = $this->http_response['422'];
                                $http_resp['errors'] = ['Please check sample file'];
                                return response()->json($http_resp,422);
                            }
                            break;
                        case "Suppliers":
                            
                            if($numcols == 14){
                                //Log::info($items);
                                $data['title'] = $filesop[0];
                                $data['first_name'] = $filesop[1];
                                $data['middle_name'] = $filesop[2];
                                $data['other_name'] = $filesop[3];
                                $data['company'] = $filesop[4];
                                $data['address'] = $filesop[5];
                                $data['city'] = $filesop[6];
                                $data['country'] = $filesop[7];
                                $data['postal_code'] = $filesop[8];
                                $data['note'] = $filesop[9];
                                $data['email'] = $filesop[10];
                                $data['phone'] = $filesop[11];
                                $data['mobile'] = $filesop[12];
                                $data['fax'] = $filesop[13];
                                array_push($items, $data);
                                //Log::info($items);
                            }else{
                                DB::rollBack();
                                $http_resp = $this->http_response['422'];
                                $http_resp['errors'] = ['Please check sample file'];
                                return response()->json($http_resp,422);
                            }
                            break;
                        case "Inventory Items": /////////////////////////////////////Inventory Items///////////////////////
                            if($numcols == 26){
                                
                                $temp_item = $request->all();
                                //Create attribute & Get content in a row
                                $data = $this->helper->create_product_attribute();
                                $data['sku_code'] = $filesop[0];
                                $data['item_name'] = $filesop[1];
                                $data['profile_name'] = $filesop[2];
                                $data['item_type'] = $filesop[3];
                                $data['unit_weight'] = $filesop[4];
                                $data['measure_unit_name'] = $filesop[5];
                                $data['measure_unit_sympol'] = $filesop[6];
                                $data['brand'] = $filesop[7];
                                $data['brand_sector'] = $filesop[8];
                                $data['manufacturer'] = $filesop[9];
                                $data['category'] = $filesop[10];
                                $data['sub_category'] = $filesop[11];
                                $data['generic_name'] = $filesop[12];
                                $data['formulation_name'] = $filesop[13];
                                $data['route_name'] = $filesop[14];
                                $data['note'] = $filesop[15];
                                $data['pack_qty'] = $filesop[16];
                                $data['prefered_supplier'] = $filesop[17];
                                $data['order_category'] = $filesop[18];
                                $data['unit_cost'] = $filesop[19];
                                $data['unit_retail'] = $filesop[20];
                                $data['pack_cost'] = $filesop[21];
                                $data['pack_retail'] = $filesop[22];
                                // $data['tax_name'] = $filesop[23];
                                // $data['tax_value'] = $filesop[24];
                                $data['status'] = $filesop[23];
                                $data['reorder_level'] = $filesop[24];
                                $data['store_location'] = $filesop[25];
                                //Reorder Point
                                if($data['reorder_level']){
                                    $temp_item['alert_indicator_level'] = $data['reorder_level'];
                                }else{
                                    $temp_item['alert_indicator_level'] = 0;
                                }
                                //Check if Unit of Measure is not applicable
                                if( ($data['measure_unit_sympol']=="n/a") || ($data['measure_unit_sympol']=="N/A") || ($data['measure_unit_sympol']=="N/a") || ($data['measure_unit_sympol']=="n/A") ){
                                    $temp_item['units_per_pack'] = 0;
                                    $temp_item['single_unit_weight'] = 0;
                                }else {
                                    //$temp_item['units_per_pack'] = 0; units_per_pack
                                    $temp_item['units_per_pack'] = $data['pack_qty'];
                                }
                                //Form a Product Item
                                //-----------------------
                                //Check if SKU Code is in use
                                $sku = $this->productItem->findByItemCode($data['sku_code']);
                                if(!$data['sku_code']){
                                    $err_line = 0;
                                    $err_line = $index+1;
                                    DB::rollBack();
                                    $http_resp = $this->http_response['422'];
                                    $http_resp['errors'] = ["Missing or invalid ITEM CODE!. Row(".$err_line.")"];
                                    return response()->json($http_resp,422);
                                }

                                if($sku){
                                    $upload_report['id'] = $index+1;
                                    $upload_report['name'] = $data['item_name'];
                                    $upload_report['status'] = false;
                                    $upload_report['description'] = "Item Code (".$data['sku_code'].") already in use";
                                    array_push($results,$upload_report);
                                }else {
                                    //Create Database Inputs here
                                    $temp_item['item_code'] = $data['sku_code'];
                                    if( $data['status'] && $data['status']=="Inactive" || $data['status']=="inactive" ){
                                        $temp_item['status'] = false;
                                    }
                                    $temp_item['single_unit_weight'] = $data['unit_weight'];

                                    //Check if product item exists
                                    //get product by name
                                    //Create Product Name----------------------
                                    $inpo = $request->all();
                                    $inpo['name'] = $data['item_name'];
                                    $product = $practiceParent->products()->where('name',$data['item_name'])->get()->first();
                                    if(!$product){
                                        if($data['item_name']){
                                            $product = $practiceParent->products()->create($inpo);
                                            $temp_item['product_id'] = $product->id;
                                        }else {
                                            $err_line = 0;
                                            $err_line = $index+1;
                                            DB::rollBack();
                                            $http_resp = $this->http_response['422'];
                                            $http_resp['errors'] = ["Missing or invalid ITEM NAME!. Row(".$err_line.")"];
                                            return response()->json($http_resp,422);
                                        }
                                    }else{
                                        $temp_item['product_id'] = $product->id;
                                    }

                                    //Create Profile Name----------------------
                                    $inpo['name'] = $data['profile_name'];
                                    $product_profile = $practiceParent->product_profiles()->where('name',$data['profile_name'])->get()->first();
                                    if(!$product_profile){
                                        //$product_profile = $this->productProfiles->getOrCreateAttributes($inpo);
                                        if($data['profile_name']){
                                            $product_profile = $practiceParent->product_profiles()->create($inpo);
                                            $temp_item['product_profile_id'] = $product_profile->id;
                                        }
                                    }else{
                                        $temp_item['product_profile_id'] = $product_profile->id;
                                    }
                                    //Create Item Type--------------------
                                    $inpo['name'] = $data['item_type'];
                                    $product_type = $practiceParent->product_type()->where('name',$data['item_type'])->get()->first();
                                    if(!$product_type){
                                        //$product_type = $this->productTypes->getOrCreateAttributes($inpo);
                                        if($data['item_type']){
                                            $product_type = $practiceParent->product_type()->create($inpo);
                                            $temp_item['product_type_id'] = $product_type->id;
                                        }
                                    }else{
                                        $temp_item['product_type_id'] = $product_type->id;
                                    }
                                    //Create UOM--------------------------
                                    $inpo['name'] = $data['measure_unit_name'];
                                    $inpo['slug'] = $data['measure_unit_sympol'];
                                    $product_unit = $practiceParent->product_units()->where('slug',$data['measure_unit_sympol'])->get()->first();
                                    if(!$product_unit){
                                        //$product_unit = $this->productUnits->getOrCreateAttributes($inpo);
                                        if($data['measure_unit_sympol']){
                                            $product_unit = $practiceParent->product_units()->create($inpo);
                                            $temp_item['product_unit_id'] = $product_unit->id;
                                        }else {
                                            $err_line = 0;
                                            $err_line = $index+1;
                                            DB::rollBack();
                                            Log::info("Empty brand sector provided");
                                            $http_resp = $this->http_response['422'];
                                            $http_resp['errors'] = ["Invalid or Missing Unit of Measure. Row(".$err_line.")"];
                                            return response()->json($http_resp,422);
                                        }
                                    }else{
                                        $temp_item['product_unit_id'] = $product_unit->id;
                                    }
                                    //Create Brand----------------------------------
                                    $inpo['name'] = $data['brand'];
                                    $product_brand = $practiceParent->product_brands()->where('name',$data['brand'])->get()->first();
                                    if(!$product_brand){
                                        //$product_unit = $this->productUnits->getOrCreateAttributes($inpo);
                                        if($data['brand']){
                                            $product_brand = $practiceParent->product_brands()->create($inpo);
                                            $temp_item['product_brand_id'] = $product_brand->id;
                                        }else {
                                            $err_line = 0;
                                            $err_line = $index+1;
                                            DB::rollBack();
                                            Log::info("Empty brand sector provided");
                                            $http_resp = $this->http_response['422'];
                                            $http_resp['errors'] = ["Missing or invalid Brand name. Row(".$err_line.")"];
                                            return response()->json($http_resp,422);
                                        }
                                    }else {
                                        $temp_item['product_brand_id'] = $product_brand->id;
                                    }
                                    //Create Brand Sector---------------------------------
                                    $inpo['name'] = $data['brand_sector'];
                                    $product_brand_sector = $practiceParent->product_brand_sector()->where('name',$data['brand_sector'])->get()->first();
                                    if(!$product_brand_sector){
                                        //$product_unit = $this->productUnits->getOrCreateAttributes($inpo);
                                        if($data['brand_sector']){
                                            $product_brand_sector = $practiceParent->product_brand_sector()->create($inpo);
                                            $temp_item['product_brand_sector_id'] = $product_brand_sector->id;
                                        }else {
                                            $err_line = 0;
                                            $err_line = $index+1;
                                            DB::rollBack();
                                            Log::info("Empty brand sector provided");
                                            $http_resp = $this->http_response['422'];
                                            $http_resp['errors'] = ["Missing or invalid Brand Sector. Row(".$err_line.")"];
                                            return response()->json($http_resp,422);
                                        }
                                    }else{
                                        $temp_item['product_brand_sector_id'] = $product_brand_sector->id;
                                    }
                                    //Create Product Manufacturer-------------------------
                                    $inpo['name'] = $data['manufacturer'];
                                    $product_manufacturer = $practiceParent->product_manufacturers()->where('name',$data['manufacturer'])->get()->first();
                                    if(!$product_manufacturer){
                                        if($data['manufacturer']){
                                            $product_manufacturer = $practiceParent->product_manufacturers()->create($inpo);
                                            $temp_item['product_manufacturer_id'] = $product_manufacturer->id;
                                        }else {
                                            $err_line = 0;
                                            $err_line = $index+1;
                                            DB::rollBack();
                                            $http_resp = $this->http_response['422'];
                                            $http_resp['errors'] = ["Missing or invalid manufacturer. Row(".$err_line.")"];
                                            return response()->json($http_resp,422);
                                        }
                                    }else{
                                        $temp_item['product_manufacturer_id'] = $product_manufacturer->id;
                                    }
                                    //Create Prefered Suppliers---------------------------------------
                                    $inpo['name'] = $data['prefered_supplier'];
                                    $product_supplier = $practiceParent->product_suppliers()->where('name',$data['prefered_supplier'])->get()->first();
                                    if(!$product_supplier){
                                        if($data['prefered_supplier']){
                                            $product_supplier = $practiceParent->product_suppliers()->create($inpo);
                                            $product_supplier = $practice->product_suppliers()->save($product_supplier);
                                            $temp_item['prefered_supplier_id'] = $product_supplier->id;
                                        }
                                    }else {
                                        $temp_item['prefered_supplier_id'] = $product_supplier->id;
                                    }
                                    //Create Categories------------------------------------------------
                                    $inpo['name'] = $data['category'];
                                    $product_category = $practiceParent->product_category()->where('name',$data['category'])->get()->first();
                                    if(!$product_category){
                                        if($data['category']){
                                            $product_category = $practiceParent->product_category()->create($inpo);
                                            $temp_item['product_category_id'] = $product_category->id;
                                        }
                                    }else {
                                        $temp_item['product_category_id'] = $product_category->id;
                                    }
                                    //Create Sub Categories------------------------------------------------
                                    $inpo['name'] = $data['sub_category'];
                                    $product_sub_category = $practiceParent->product_sub_category()->where('name',$data['sub_category'])->get()->first();
                                    if(!$product_sub_category){
                                        if($data['sub_category']){
                                            $product_sub_category = $practiceParent->product_sub_category()->create($inpo);
                                            $temp_item['product_sub_category_id'] = $product_sub_category->id;
                                        }
                                    }else {
                                        $temp_item['product_sub_category_id'] = $product_sub_category->id;
                                    }
                                    //Create Generics------------------------------------------------------
                                    $inpo['name'] = $data['generic_name'];
                                    $product_generic = $practiceParent->generics()->where('name',$data['generic_name'])->get()->first();
                                    if(!$product_generic){
                                        if($data['generic_name']){
                                            $product_generic = $practiceParent->generics()->create($inpo);
                                            $temp_item['generic_id'] = $product_generic->id;
                                        }
                                    }else {
                                        $temp_item['generic_id'] = $product_generic->id;
                                    }
                                    //Create Formulation-----------------------------------------------------
                                    $inpo['name'] = $data['formulation_name'];
                                    $product_formulation = $practiceParent->product_formulations()->where('name',$data['formulation_name'])->get()->first();
                                    if(!$product_formulation){
                                        if($data['formulation_name']){
                                            $product_formulation = $practiceParent->product_formulations()->create($inpo);
                                            $temp_item['product_formulation_id'] = $product_formulation->id;
                                        }
                                    }else{
                                        $temp_item['product_formulation_id'] = $product_formulation->id;
                                    }
                                    //Create Route-----------------------------------------------------------
                                    $inpo['name'] = $data['route_name'];
                                    $product_route = $practiceParent->product_route()->where('name',$data['route_name'])->get()->first();
                                    if(!$product_route){
                                        if($data['route_name']){
                                            $product_route = $practiceParent->product_route()->create($inpo);
                                            $temp_item['product_route_id'] = $product_route->id;
                                        }
                                    }else{
                                        $temp_item['product_route_id'] = $product_route->id;
                                    }
                                    //Create Order Category--------------------------------------------------
                                    $inpo['name'] = $data['order_category'];
                                    $product_order_category = $practiceParent->product_order_category()->where('name',$data['order_category'])->get()->first();
                                    if(!$product_order_category){
                                        if($data['order_category']){
                                            $product_order_category = $practiceParent->product_order_category()->create($inpo);
                                            $temp_item['product_order_category_id'] = $product_order_category->id;
                                        }
                                    }else{
                                        $temp_item['product_order_category_id'] = $product_order_category->id;
                                    }

                                    // $data['unit_cost'] = $filesop[19];
                                    // $data['unit_retail'] = $filesop[20];
                                    // $data['pack_cost'] = $filesop[21];
                                    // $data['pack_retail'] = $filesop[22];
                                    // $data['reorder_level'] = $filesop[24];
                                    // $data['store_location'] = $filesop[25];
                                    $temp_item['unit_cost'] = $data['unit_cost'];
                                    $temp_item['unit_retail'] = $data['unit_retail'];
                                    $temp_item['pack_cost'] = $data['pack_cost'];
                                    $temp_item['pack_retail'] = $data['pack_retail'];
                                    // $temp_item['alert_indicator_level'] = $data['reorder_level'];
                                    $temp_item['unit_storage_location'] = $data['store_location'];
                                    $temp_item['item_note'] = $data['note'];


                                    //$product = $this->practice->setProduct($practiceParent, $inpo);
                                    //Set
                                    //get generic by name
                                    //$inpo['name'] = $request->generic_name;
                                    //$inpo['name'] = $data['generic_name'];
                                    //$generics = $this->practice->setGeneric($practiceParent,$inpo);
                                    // //--------------------------------------------------------------
                                    // //find manufacturere by name
                                    // //$inpo['name'] = $request->manufacturer;
                                    // $inpo['name'] = $data['manufacturer'];
                                    // $manufacturer = $this->manufacturer->store($inpo);
                                    // //set brand name
                                    // //$item_type = $this->item_type->findByName($request->item_type);
                                    // //$inpo['name'] = $request->item_type;
                                    // $inpo['name'] = $data['profile_name'];
                                    // //$profile_name = $this->productPro
                                    // //$item_type = $this->practice->setProductType($practiceParent,$inpo);

                                    // //$inpo['name'] = $request->brand_name;
                                    // $inpo['name'] = $data[$k]->brand;
                                    // $brand = $this->practice->setBrand($parent_practice,$inpo);

                                    // //$inpo['name'] = $request->brand_sector;
                                    // $inpo['name'] = $data[$k]->brand_sector;
                                    // $brand_sect = $this->practice->setBrandSector($parent_practice,$inpo);

                                    // //$inpo['name'] = $request->item_category;
                                    // $inpo['name'] = $data[$k]->category;
                                    // $category = $this->practice->setCategory($parent_practice,$inpo);

                                    // $inpo['name'] = $data[$k]->measure_unit_name;
                                    // $inpo['slug'] = $data[$k]->measure_unit_symbol;
                                    // $units = $this->practice->setUnits($parent_practice,$inpo);
                                    // //--------------------------------------------------------------
                                
                                    
                                    if($index > 0){
                                        $product_item = $practiceParent->product_items()->create($temp_item);
                                        $prices = [
                                            'practice_product_item_id' => $product_item->id,
                                            'practice_id' => $practice->id,
                                            'unit_cost' => 100,
                                            'unit_retail_price' => 150,
                                            'pack_cost' => 1000,
                                            'pack_retail_price' => 1500,
                                        ];
                                        $prc = $this->practiceProductItem->setProductItemPrice($product_item, $prices);
                                        $upload_report['id'] = $index+1;
                                        $upload_report['name'] = $data['item_name'];
                                        $upload_report['status'] = true;
                                        $upload_report['description'] = "Created successful!";
                                        array_push($results,$upload_report);
                                    }

                                }
                                
                            }else{
                                DB::rollBack();
                                $http_resp = $this->http_response['422'];
                                $http_resp['errors'] = ['Please check sample file to proceed!'];
                                return response()->json($http_resp,422);
                            }
                            break;
                    }
                    $index += 1;
                }
                //
                if( !$request->upload_type == "Inventory Items" ){
                    //Call the "store_upload" method to save into database
                    $results = $this->store_upload($practice,$items,$request->upload_type);
                    $http_resp['results'] = $results;
                    $http_resp['description'] = "Successful uploaded!";
                }else {
                    $http_resp['results'] = $results;
                }
            }else{
                //DB::rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['File must be a CSV'];
                return response()->json($http_resp,422);
            }
        }catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::commit();
        return response()->json($http_resp);
    }

}

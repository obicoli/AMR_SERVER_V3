<?php


namespace App\Repositories\Product;


use App\helpers\HelperFunctions;
use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Accounts\ProductAccountDetailType;
use App\Models\Product\Accounts\ProductAccountType;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Models\Product\Accounts\ProductVoucher;
use App\Models\Product\Product;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\Route\ProductRoutes;
use App\Models\Product\ProductBank;
use App\Models\Product\ProductBankBranch;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCurrency;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Product\Sales\ProductPriceRecord;
use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Inventory\ProductStock;
use App\Models\Module\Module;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\Vaccine\ProductVaccine;
use App\Models\Product\ProductFormulation;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductManufacture;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Profile\ProductProfile;
use App\Models\Product\Store\ProductStore;

class ProductReposity implements ProductReposityInterface
{
    protected $model;
    protected $helper;
    protected $practiceRepository;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->helper = new HelperFunctions();
        $this->practiceRepository = new PracticeRepository( new Practice() );
    }

    public function getOrCreateAttributes($attr=[]){
        $result = null; //Return value
        //$owner - This can be facility branch or Main Branch
        //$attr - This is Product Item attributes e.g Profile name and should be in array
        if( array_key_exists("name",$attr) && $attr["name"] ){//Check if attribute name exists and is not null
            $attribute_model = $this->model->all()->where('name',$attr['name'])->first();
            if($attribute_model){
                $result = $attribute_model;
            }else{
                $result = $this->model->create($attr);
            }
        }else{
            $result = null;
        }
    }

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all()->sortBy('name');
    }

    public function create(array $arr)
    {
        // TODO: Implement create() method.
        // $check = $this->model->all()->where('name',$arr['name'])->where('practice_id',$arr['practice_id'])->first();
        // if ($check){
        //     return $check;
        // }
        return $this->model->create($arr);
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
        return $this->model->find($id)->delete();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->model->all()->where('uuid', $uuid)->first();
    }

    public function findByName($name)
    {
        // TODO: Implement findByName() method.
        return $this->model->all()->where('name', $name)->first();
    }

    public function getName($id, $slug = null)
    {
        // TODO: Implement getName() method.
        if ($id) {
            $item = $this->model->find($id);
            if ($slug && $item) {
                return $item->slug;
            } elseif($item) {
                return $item->name;
            }else{
                return null;
            }
        } else {
            return null;
        }
    }

    public function getPrices($id, $type)
    {
        // TODO: Implement getPrices() method.
        $prices = $this->model->all()->where('practice_product_item_id', $id)->where('status', true)->first();
        $res = 0;

        if ($prices) {
            switch ($type) {
                case "unit_cost":
                    $res = $prices->unit_cost;
                    break;
                case "unit_retail_price":
                    $res = $prices->unit_retail_price;
                    break;
                case "pack_cost":
                    $res = $prices->pack_cost;
                    break;
                case "pack_retail_price":
                    $res = $prices->pack_retail_price;
                    break;
            }
        } else {
            $res = 0;
        }

        return $res;
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
        $data = $this->model->find($id);
        return $data->update($arr);
    }

    public function paginated($paginate=15){
        return $this->model->paginate($paginate);
    }

    public function isInventoryItemExist($inputs = [])
    {
        // TODO: Implement isInventoryItemExist() method.
        $item = $this->model->all()
            ->where('product_brand_id',$inputs['product_brand_id'])
            ->where('product_brand_sector_id',$inputs['product_brand_sector_id'])
            ->where('product_unit_id',$inputs['product_unit_id'])
            ->where('single_unit_weight',$inputs['single_unit_weight'])
            ->first();
        return $item;
    }


    public function transform_attribute(Model $model){
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'description' => $model->description,
            'status' => $model->status,
        ];
    }

    public function transform_unit(ProductUnit $productUnit){
        return [
            'id' => $productUnit->uuid,
            'name' => $productUnit->name,
            'description' => $productUnit->description,
            'status' => $productUnit->status,
            'slug'=>$productUnit->slug,
        ];
    }

    public function transform_store(ProductStore $productStore){
        return [
            'id'=>$productStore->getUuid(),
            'name'=>$productStore->getName(),
            'email'=>$productStore->getEmail(),
            'mobile'=>$productStore->getMobile(),
            'status'=>$productStore->getStatus(),
            'is_default'=>$productStore->getIsDefault(),
        ];
    }

    public function transform_taxation(ProductTaxation $productTaxation){

//        $temp_data['id'] = $productTaxation->uuid;
//        $temp_data['collected_on_purchase'] = $productTaxation->collected_on_purchase;
//        $temp_data['collected_on_sales'] = $productTaxation->collected_on_sales;
//        $temp_data['agent_name'] = $productTaxation->agent_name;
//        $temp_data['name'] = $productTaxation->name;
//        $temp_data['registration_number'] = $productTaxation->registration_number;
//        $temp_data['description'] = $productTaxation->description;
//        $temp_data['start_period'] = $productTaxation->start_period;
//        $temp_data['filling_frequency'] = $productTaxation->filling_frequency;
//        $temp_data['reporting_method'] = $productTaxation->reporting_method;
//        $temp_data['purchase_rate'] = $productTaxation->purchase_rate;
//        $temp_data['sales_rate'] = $productTaxation->sales_rate;
//        $temp_data['amount'] = $productTaxation->amount;
//        $temp_data['status'] = $productTaxation->status;
//        $temp_data['display_as'] = $productTaxation->name.' '.$productTaxation->category.'('.number_format($productTaxation->sales_rate,1).'%)';

        // $temp_data_t['id'] = $productTaxation->uuid;
        // $temp_data_t['collected_on_purchase'] = $productTaxation->collected_on_purchase;
        // $temp_data_t['collected_on_sales'] = $productTaxation->collected_on_sales;
        // $temp_data_t['agent_name'] = $productTaxation->agent_name;
        // $temp_data_t['name'] = $productTaxation->name;
        // $temp_data_t['registration_number'] = $productTaxation->registration_number;
        // $temp_data_t['description'] = $productTaxation->description;
        // $temp_data_t['start_period'] = $productTaxation->start_period;
        // $temp_data_t['filling_frequency'] = $productTaxation->filling_frequency;
        // $temp_data_t['reporting_method'] = $productTaxation->reporting_method;
        // $temp_data_t['purchase_rate'] = $productTaxation->purchase_rate;
        // $temp_data_t['sales_rate'] = $productTaxation->sales_rate;
        // $temp_data_t['amount'] = $productTaxation->amount;
        // $temp_data_t['status'] = $productTaxation->status;
        //return $temp_data;
        return [];

    }

    public function transform_price(ProductPriceRecord $productPriceRecord){
        return [
            'id'=>$productPriceRecord->uuid,
            'unit_cost'=>$productPriceRecord->unit_cost,
            'unit_retail_price'=>$productPriceRecord->unit_retail_price,
            'pack_cost'=>$productPriceRecord->pack_cost,
            'pack_retail_price'=>$productPriceRecord->pack_retail_price,
            'status'=>$productPriceRecord->status,
            'start_date'=>$productPriceRecord->start_date,
        ];
    }

    public function transform_product_item(ProductItem $productItem, Practice $practice=null){

        // return [
        //     'id' => $productItem->uuid,
        //     'item_code' => $productItem->item_code,
        //     'item_note' => $productItem->item_note,
        //     'unit_weight' => $productItem->single_unit_weight,
        //     'reorder_point' => $productItem->alert_indicator_level,
        //     'pack_qty' => $productItem->units_per_pack,
        //     'storage_location' => $productItem->unit_storage_location,
        //     'stock' => 0,
        // ];

        //Product name
        $product = $productItem->products()->get()->first();
        $item_name = array();
        if($product){ $item_name['id'] = $product->uuid; $item_name['name'] = $product->name; }
        //Brand name
        $branda = $productItem->brands()->get()->first();
        $brand = [ 'id'=>'','name'=>''];
        if($branda){ $brand['id']=$branda->uuid; $brand['name']=$branda->name; }
        //Brand Sector
        $brand_sector = [ 'id'=>'', 'name'=>'' ];
        $brand_sect = $productItem->brand_sectors()->get()->first();
        if($brand_sect){ $brand_sector['id']=$brand_sect->uuid; $brand_sector['name']=$brand_sect->name;}
        //Measure units
        $measure_unit_name = ['id'=>'','name'=>'','slug'=>''];
        $uom = $productItem->units_of_measure()->get()->first();
        if($uom){ $measure_unit_name['id']=$uom->uuid; $measure_unit_name['slug']=$uom->slug; $measure_unit_name['name']=$uom->name;}

        //Taxes
        $item_taxes = array();
        $practiceRepository = new PracticeRepository( new Practice() );
        $taxes = $productItem->taxations()->get();
        foreach ($taxes as $taxe){
            array_push($item_taxes,$practiceRepository->transformPracticeTaxation($taxe));
        }

        //Category
        $category = ['id'=>'','name'=>''];
        $catego = $productItem->product_category()->get()->first();
        if($catego){
            $category = ['id'=>$catego->uuid,'name'=>$catego->name];
        }
        //Manufacturer
        $manufacturer = ['id'=>'','name'=>''];
        $manufa = $productItem->product_manufacturer()->get()->first();
        if($manufa){
            $manufacturer = ['id'=>$manufa->uuid,'name'=>$manufa->name];
        }
        //Profile
        $profile = ['id'=>'','name'=>''];
        $profila = $productItem->profiles()->get()->first();
        if($profila){
            $profile = ['id'=>$profila->uuid,'name'=>$profila->name];
        }
        //Generic
        $generic = ['id'=>'','name'=>''];
        $gene = $productItem->product_generic()->get()->first();
        if($gene){ $generic = ['id'=>$gene->uuid,'name'=>$gene->name]; }
        
        //Stock
        $stock = 0;
        $stock_packs = 0;
        $stock_units = 0;
        //Opening Stock
        $opening_stock = 0;
        if($practice){
            //$stock = $practice->product_stock_inward()->where('product_item_id',$productItem->id)->sum('amount') - $practice->product_stock_inward()->where('product_item_id',$productItem->id)->sum('consumed_amount');
            //$opening_stock = $practice->product_stock_inward()->where('product_item_id',$productItem->id)->where('source_type',Product::STOCK_SOURCE_OPENING_STOCK)->sum('amount');
        }
        //Price
        $pricez = $productItem->price_record()->get()->first();
        $price = [
            'id'=>'',
            'unit_cost' => 0,
            'unit_retail_price' => 0,
            'pack_cost' => 0,
            'pack_retail_price' => 0,
        ];
        
        if($pricez){
            $price = [
                'id'=>$pricez->uuid,
                'unit_cost' => $pricez->unit_cost,
                'unit_retail_price' => $pricez->unit_retail_price,
                'pack_cost' => $pricez->pack_cost,
                'pack_retail_price' => $pricez->pack_retail_price,
            ];
        }

        //Item Type
        $product_type = $productItem->product_types()->get()->first();
        $item_type = ['id'=>'','name'=>''];
        if($product_type){
            $item_type = ['id'=>$product_type->uuid,'name'=>$product_type->name];
        }

        //Order Category
        $order_categora = $productItem->product_order_category()->get()->first();
        $order_category = ['id'=>'','name'=>''];
        if($order_categora){
            $order_category = ['id'=>$order_categora->uuid,'name'=>$order_categora->name];
        }

        //Sub Category
        $sub_categora = $productItem->product_sub_category()->get()->first();
        $sub_category = ['id'=>'','name'=>''];
        if($sub_categora){
            $sub_category = ['id'=>$sub_categora->uuid,'name'=>$sub_categora->name];
        }

        //Product Route
        $product_route = ['id'=>'','name'=>''];
        $product_rout = $productItem->product_routes()->get()->first();
        if($product_rout){
            $product_route = ['id'=>$product_rout->id,'name'=>$product_rout->name];
        }

        //formulation
        $formulation = ['id'=>'','name'=>''];
        $formulate = $productItem->product_formulations()->get()->first();
        if($formulate){
            $formulation = ['id'=>$formulate->uuid,'name'=>$formulate->name];
        }

        //supplier
        $supplier = ['id'=>'','name'=>''];
        $suppli = $productItem->prefered_suppliers()->get()->first();
        if($suppli){
            $supplier = ['id'=>$suppli->uuid,'name'=>$suppli->name];
        }
        

        return [
            'id'=>$productItem->uuid,
            'item_name'=>$item_name,
            'item_type'=>$item_type,
            'generic'=>$generic,
            'sku_code'=>$productItem->item_code,
            'category'=>$category,
            'order_category'=>$order_category,
            'sub_category'=>$sub_category,
            'route'=>$product_route,
            'formulation'=>$formulation,
            'supplier'=>$supplier,
            'manufacturer'=>$manufacturer,
            'profile'=>$profile,
            'brand'=>$brand,
            'brand_sector'=>$brand_sector,
            'measure_unit'=>$measure_unit_name,
            'single_unit_weight'=>$productItem->single_unit_weight,
            'units_per_pack'=>$productItem->units_per_pack,
            'pack_qty'=>$productItem->units_per_pack,
            'alert_indicator_level'=>$productItem->alert_indicator_level,
            // 'unit_cost'=>0,
            // 'unit_retail'=>0,
            // 'pack_cost'=>0,
            // 'pack_retail'=>$productItem,
            'taxes'=>$item_taxes,
            'note'=>$productItem->item_note,
            'store_location'=>$productItem->unit_storage_location,
            'price'=>$price,
            'price_after_tax'=>$this->helper->taxation_calculation($price,$item_taxes),
            'qty' => 1,//from here are transactional
            //'batch_number' => '',
            //'exp_month' => '',
            //'exp_year' => '',
            //'description' => '',
            'amount' => 0,
            'discount_rate' => 0,
            'line_taxation' => 0,
            'line_exlusive' => 0,
            'line_total' => 0,
            'sub_stock_total'=> 0,
            'line_discount' => 0,
            //'batched_stock' => [],
            //'default_batched_stock'=>[],
            'stock'=>$stock,
            'stock_units'=>$stock_units,
            'stock_packs'=>$stock_packs,
            'opening_stock'=>$opening_stock,
            'applied_tax_rates'=>[],
        ];

    }

    public function transform_($collection)
    {
        // TODO: Implement transform_() method.
        return [
            'id' => $collection->uuid,
            'name' => $collection->name,
            'slug' => $collection->slug,
            'status' => $collection->status,
            'description' => $collection->description,
        ];
    }


    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        // $results = array();
        // foreach ($collections as $collection) {
        //     array_push($results, $this->transform_($collection));
        // }
        // return $results;
    }

    public function createSale(Practice $practice, array $arr)
    {
        // TODO: Implement createSale() method.
    }

    public function createPurchase(Practice $practice, array $arr)
    {
        // TODO: Implement createPurchase() method.
    }

    public function getCategories(Practice $practice = null)
    {
        // TODO: Implement getCategories() method.
        if ($practice){
            //->orderBy('created_at')->paginate(15);
            $parentPractice = $this->practiceRepository->findParent($practice);
            //return $parentPractice->product_category()->get()->sortBy('name');
            return $parentPractice->product_category()->orderBy('created_at')->paginate(15);
        }else{
            return ProductCategory::orderBy('created_at')->paginate(15);
        }
    }

    public function getUnits(Practice $practice = null)
    {
        // TODO: Implement getCategories() method.
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->product_units()->get()->sortBy('name');
        }else{
            return ProductUnit::all()->sortBy('name');
        }
    }

    public function getTypes(Practice $practice = null)
    {
        // TODO: Implement getTypes() method.
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->product_type()->get()->sortBy('name');
        }else{
            return ProductCategory::all()->sortBy('name');
        }
    }

    public function getGenerics(Practice $practice = null){
        // TODO: Implement getTypes() method.
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->generics()->get()->sortBy('name');
        }else{
            return ProductGeneric::all()->sortBy('name');
        }
    }

    public function getBrands(Practice $practice = null){
        // TODO: Implement getTypes() method.
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->product_brands()->get()->sortBy('name');
        }else{
            return ProductBrand::all()->sortBy('name');
        }
    }

    public function getBrandSector(Practice $practice = null){
        // TODO: Implement getTypes() method.
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->product_brand_sector()->get()->sortBy('name');
        }else{
            return ProductBrandSector::all()->sortBy('name');
        }
    }

    public function getAttributes(Practice $practice, $attribute_type = null){
        // TODO: Implement getTypes() method.
        // if ($practice){
        //     $parentPractice = $this->practiceRepository->findParent($practice);
        //     return $parentPractice->generics()->get()->sortBy('name');
        // }else{
        //     return ProductGeneric::all()->sortBy('name');
        // }

        $parentPractice = $this->practiceRepository->findParent($practice);

        $results = array();
        $generi = array();
        $item_names = array();
        $item_types = array();
        $manufacturer = array();
        $brands = array();
        $brand_sectors = array();
        $categories = array();
        $order_categories = array();
        $sub_categories = array();
        $units = array();
        $taxes = array();
        $routes = array();
        $formulations = array();
        $vaccines = array();
        $profiles = array();
        $product_types = array();
        $suppliers = array();

        if($attribute_type){

        }else{

            //Product Admin Route
            $adminRoutes = $this->getRoutes($parentPractice,null);
            //Product Formulation
            $productFormulations = $this->getFormulations($parentPractice,null);
            //Product Vaccines
            $adminVaccines = $this->getVaccines($parentPractice,null);
            //product profile
            $productProfiles = $this->getProductProfile($parentPractice,null);
            //product type
            $product_typess = $parentPractice->product_type()->get()->sortBy('name');
            //$product_typess = $this->getProductTypes($parentPractice,null);
            foreach($product_typess as $product_type){
                $temp_rops['id'] = $product_type->uuid;
                $temp_rops['name'] = $product_type->name;
                $temp_rops['description'] = $product_type->description;
                array_push($product_types, $temp_rops);
            }

            foreach($productProfiles as $productProfile){
                $temp_rop['id'] = $productProfile->uuid;
                $temp_rop['name'] = $productProfile->name;
                $temp_rop['description'] = $productProfile->description;
                array_push($profiles, $temp_rop);
            }

            foreach($adminRoutes as $adminRoute){
                $temp_ro['id'] = $adminRoute->uuid;
                $temp_ro['name'] = $adminRoute->name;
                $temp_ro['description'] = $adminRoute->description;
                array_push($routes, $temp_ro);
            }

            foreach($productFormulations as $productFormulation){
                $temp_ros['id'] = $productFormulation->uuid;
                $temp_ros['name'] = $productFormulation->name;
                $temp_ros['description'] = $productFormulation->description;
                array_push($formulations, $temp_ros);
            }

            foreach($adminVaccines as $adminVaccine){
                $temp_ross['id'] = $adminVaccine->uuid;
                $temp_ross['name'] = $adminVaccine->name;
                $temp_ross['description'] = $adminVaccine->description;
                array_push($vaccines, $temp_ross);
            }

            //Item name
            $itemNames = $this->getProducts($practice);
            foreach( $itemNames as $itemName ){
                $item_nam['id'] = $itemName->uuid;
                $item_nam['name'] = $itemName->name;
                array_push($item_names,$item_nam);
            }

            $generics = $this->getGenerics($practice);
            
            foreach($generics as $generic){
                $data['id'] = $generic->uuid;
                $data['name'] = $generic->name;
                array_push($generi,$data);
            }

            //$manufactures = Manufacturer::all()->sortBy('name');
            $manufactures = ProductManufacture::all()->sortBy('name');
            foreach($manufactures as $manufacture){
                $dat['id']= $manufacture->uuid;
                $dat['name']= $manufacture->name;
                array_push($manufacturer,$dat);
            }

            //$manufactures = Manufacturer::all()->sortBy('name');


            $branda = $this->getBrands($practice);
            foreach($branda as $brand){
                $bdta['id'] = $brand->uuid;
                $bdta['name'] = $brand->name;
                array_push($brands,$bdta);
            }

            $brandasectors = $this->getBrandSector($practice);
            foreach($brandasectors as $brandss){
                $sdta['id'] = $brandss->uuid;
                $sdta['name'] = $brandss->name;
                array_push($brand_sectors,$sdta);
            }

            $supplies = $parentPractice->product_suppliers()->get()->sortBy('name');
            foreach($supplies as $supplie){
                $supp['id']= $supplie->uuid;
                $supp['company']= $supplie->company;
                array_push($suppliers,$supp);
            }
            //$categoras = $this->getCategories($practice);
            //$parentPractice = $this->practiceRepository->findParent($practice);
            $categoras = $parentPractice->product_category()->get()->sortBy('name');
            foreach($categoras as $categori){
                $dta['id'] = $categori->uuid;
                $dta['name'] = $categori->name;
                $dta['status'] = $categori->status;
                $dta['description'] = $categori->description;
                array_push($categories,$dta);
            }
            //Order Category
            $order_categoras = $parentPractice->product_order_category()->get()->sortBy('name');
            foreach($order_categoras as $order_categora){
                $dtaz['id'] = $order_categora->uuid;
                $dtaz['name'] = $order_categora->name;
                $dtaz['status'] = $order_categora->status;
                $dtaz['description'] = $order_categora->description;
                array_push($order_categories,$dtaz);
            }
            //sub_categories
            $sub_categoras = $parentPractice->product_sub_category()->get()->sortBy('name');
            foreach($sub_categoras as $sub_categora){
                $dtsba['id'] = $sub_categora->uuid;
                $dtsba['name'] = $sub_categora->name;
                $dtsba['status'] = $sub_categora->status;
                $dtsba['description'] = $sub_categora->description;
                array_push($sub_categories,$dtsba);
            }
            

            $unitsss = $this->getUnits($practice);
            foreach($unitsss as $unitss){
                $uni['id'] = $unitss->uuid;
                $uni['name'] = $unitss->name;
                $uni['slug'] = $unitss->slug;
                array_push($units,$uni);
            }

            $taxesy = $parentPractice->product_taxations()->get();
            foreach($taxesy as $taxe){
                array_push($taxes,$this->transform_taxation($taxe));
            }

            $results['categories'] = $categories;
            $results['order_categories'] = $order_categories;
            $results['sub_categories'] = $sub_categories;
            $results['item_names'] = $item_names;
            $results['generics'] = $generi;
            $results['manufacturers'] = $manufacturer;
            $results['profile_names'] = $profiles;//$this->practiceRepository->getProductType($practice);
            $results['brands'] = $brands;
            $results['brand_sectors'] = $brand_sectors;
            
            $results['units'] = $units;
            $results['taxes'] = $taxes;
            $results['routes'] = $routes;
            $results['formulations'] = $formulations;
            $results['vaccines'] = $vaccines;
            $results['profiles'] = $profiles;
            $results['item_types'] = $product_types;
            $results['suppliers'] = $suppliers;
        }
        return $results;
    }

    public function getOrCreate($name){

        $item = $this->model->all()->where('name',$name)->first();
        if($item){
            return $item;
        }else{
            return $this->model->create(['name'=>$name]);
        }
    }

    public function getProducts(Practice $practice = null){
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->products()->get()->sortBy('name');
        }else{
            return Product::all()->sortBy('name');
        }
    }

    public function getTax(Practice $practice, PracticeProductItem $practiceProductItem = null){
        if ($practice){
            $parentPractice = $this->practiceRepository->findParent($practice);
            return $parentPractice->sales_charge()->get()->sortBy('name');
        }else{
            return ProductBrandSector::all()->sortBy('name');
        }
    }

    public function getStores(Model $model, $type=null){
        if($type){
            return $model->stores()->get()->where('type',$type)->sortBy('name');
        }else{
            return $model->stores()->get()->sortBy('name');
        }
    }

    public function getRoutes(Model $model = null, $type=null){
        if($type){
            return $model->product_routes()->get()->where('type',$type)->sortBy('name');
        }elseif($model){
            return $model->product_routes()->get()->sortBy('name');
        }else{
            //return $model->product_routes()->get()->sortBy('name');
            return ProductRoutes::all()->sortBy('name');
        }
    }

    public function getVaccines(Model $model = null, $type=null){
        if($type){
            return $model->product_vaccines()->get()->where('type',$type)->sortBy('name');
        }elseif($model){
            return $model->product_vaccines()->get()->sortBy('name');
        }else{
            return ProductVaccine::all()->sortBy('name');
        }
    }

    public function getFormulations(Model $model = null, $type=null){
        if($type){
            return $model->product_formulations()->get()->where('type',$type)->sortBy('name');
        }elseif($model){
            return $model->product_formulations()->get()->sortBy('name');
        }else{
            return ProductFormulation::all()->sortBy('name');
        }
    }

    public function getProductProfile(Model $model = null, $type=null){

        if($type){
            return $model->product_formulations()->get()->where('type',$type)->sortBy('name');
        }elseif($model){
            return $model->product_profiles()->get()->sortBy('name');
        }else{
            return ProductProfile::all()->sortBy('name');
        }

    }

    public function getProductTypes(Model $model = null, $type=null){

        if($type){
            return $model->product_formulations()->get()->where('type',$type)->sortBy('name');
        }elseif($model){
            return $model->product_profiles()->get()->sortBy('name');
        }else{
            return ProductType::all()->sortBy('name');
        }

    }

    //
    public function getItemSalesCharge(Practice $practice)
    {
        // TODO: Implement getItemSalesCharge() method.
        $results = array();
        $parentMain = $this->practiceRepository->findParent($practice);
        $sales = $parentMain->sales_charge()->get()->sortByDesc('created_at');
        //Log::info($sales);
        foreach ($sales as $sale) {
            $temp_data['id'] = $sale->uuid;
            $temp_data['name'] = $sale->name;
            $temp_data['amount'] = $sale->amount;
            $temp_data['status'] = $sale->status;
            array_push($results, $temp_data);
        }
        return $results;
    }

    public function findByCode(Model $model, $code)
    {
        // TODO: Implement findByCode() method.
        return $model->product_items()->get()->where('item_code', $code)->first();
    }

    public function findByItemCode($code){
        //return $this->model->
    }

    public function setProductItem(Model $model, array $arr)
    {
        // TODO: Implement setProductItem() method.
        return $model->product_items()->create($arr);
    }

    public function setTax(Model $model, array $arr){
        //$tax
        //return $model->sales_charge()->create($arr);
        $prod = $model->sales_charge()->get()->where('name',$arr['name'])->first();
        if($prod){
            return $prod;
        }else{
            return $model->sales_charge()->create($arr);
        }
    }

    public function setProductType(Model $model, array $arr){

    }

    public function setProduct(Practice $practice, array $array){

        // $prod = $practice->products()->get()->where('name',$array['name'])->first();
        // if($prod){
        //     return $prod;
        // }else{
        //     return $practice->products()->create($array);
        // }
        
    }

    public function getProductItem(Practice $practice, array $filters = [])
    {
        // TODO: Implement getProductItem() method.
        $results = array();
        $parentMain = $this->practiceRepository->findParent($practice);
        if(sizeof($filters) > 0){
            return $items = $parentMain->product_items()->paginate(10);//->where($filters['column'],$filters['value'])->sortByDesc('created_at');
        }else{
            return $items = $parentMain->product_items()->paginate(10);//->sortByDesc('created_at');
        }
    }

    // public function transform_product_item(ProductItem $practiceProductItem,$source=null,Practice $practice=null, $parentPractice=null)
    // {
    //     // TODO: Implement transform_product_item() method.

    //     $stocks = array();
    //     $stock_batched = array();
    //     $stocks_total = 0;
    //     if($practice){
    //         //$stock_records = $practice->product_stock_inward()->get();
    //         $stock_records = $practiceProductItem->product_stock_inward()
    //         ->where('owning_id',$practice->id)
    //         ->where('owning_type',Practice::NAME_SPACE)
    //         ->orderBy('exp_date')
    //         ->get();
    //         foreach ( $stock_records as $stock_record ) {
    //             $data['id'] = $stock_record->uuid;
    //             $data['batch_number'] = $stock_record->batch_number;
    //             $data['stock'] = $stock_record->amount;
    //             $data['name'] = "#".$stock_record->batch_number." | Exp:".$this->helper->format_mysql_date($stock_record->exp_date,"M")." ".$this->helper->format_mysql_date($stock_record->exp_date,"Y")." | Stock ".$stock_record->amount;
    //             array_push($stock_batched,$data);
    //         }
    //         return $stock_batched;

    //     }elseif($parentPractice){
            
    //         $practices = $parentPractice->practices()->get();
    //         foreach($practices as $practic){
    //             $data['facility_id'] = $practic->uuid;
    //             $data['facility_name'] = $practic->name;
    //             $data['longitude'] = $practic->longitude;
    //             $data['latitude'] = $practic->latitude;
    //             $product_stocks = $practic->product_stock()
    //             ->get()
    //             ->where('is_depleted',false)
    //             ->where('product_item_id',$practiceProductItem->id);
    //             $batches = array();
    //             foreach($product_stocks as $product_stock){
    //                 $batch['batch_number'] = $product_stock->batch_number;
    //                 $batch['mfg_date'] = $product_stock->mfg_date;
    //                 $batch['exp_date'] = $product_stock->exp_date;
    //                 $batch['qty'] = $product_stock->amount - $this->sumStocks($product_stock);//$product_stock->batch_number;
    //                 array_push($batches,$batch);
    //             }
    //             $data['current_stocks'] = $batches;
    //             array_push($stocks,$data);
    //         }
    //         //$item['stock'] = $stocks;
    //     }else{
    //         $item = $this->helper->create_product_attribute($practiceProductItem,"Low");
    //         $item['stock_total'] = $item['stock'];
    //     }
    //     // $item['stock_total'] = 2000;
    //     // $item['stock'] = $stocks;
    //     return $item;
    // }

    public function checkExistence(array $arr){

        if( $this->model->all()->where('name',$arr['name'])->where('practice_id',$arr['practice_id'])->first() ){
            return true;
        }else{
            return false;
        }

    }

    public function setProductItemPrice(ProductItem $practiceProductItem, $prices)
    {
        // TODO: Implement setProductItemPrice() method.
        $prc = $practiceProductItem->all()
            ->where('practice_id', $prices['practice_id'])
            ->where('practice_product_item_id', $prices['practice_product_item_id'])->first();
        if ($prc) {
            $prc->status = false;
            $prc->save();
        }
        return $practiceProductItem->price_record()->create($prices);
    }

    public function getStock(PracticeProductItem $practiceProductItem)
    {
        // TODO: Implement getStock() method.
        //$purchase_count = $practiceProductItem->purchases()->get()
    }

    public function sumStocks(ProductStock $productStock)
    {
        // TODO: Implement sumStocks() method.
        //return $practiceProductItem->purchases()->where('status', $stock_status)->count(Product::PURCHASE_QTY);
        return $productStock->product_stock_movement()->sum('quantity');
    }

    public function getAccountHolders(Practice $practice)
    {
        // TODO: Implement getAccountHolders() method.
        $results = array();
        $userRepo = new UserRepository(new User());
        $account_holders = $practice->practice_account_holder()->get()->sortByDesc('created_at');
        //Log::info($account_holders);
        //Log::info($account_holders);
        foreach ($account_holders as $account_holder) {
            $temp_data['id'] = $account_holder->uuid;
            $temp_data['title'] = $account_holder->title;
            $temp_data['logo'] = $account_holder->logo;
            $temp_data['mobile'] = $account_holder->mobile;
            $temp_data['email'] = $account_holder->email;
            $temp_data['address'] = $account_holder->address;
            $temp_data['national_id'] = $account_holder->national_id;
            $temp_data['company_name'] = $account_holder->company_name;
            $temp_data['country'] = $account_holder->country;
            $temp_data['town'] = $account_holder->town;
            $temp_data['description'] = $account_holder->description;
            $temp_data['logo'] = $account_holder->logo;
            $temp_data['created_at'] = date('Y-m-d', strtotime($account_holder->created_at));
            $temp_data['created_by'] = $userRepo->getCreatedBy($userRepo->findRecord($account_holder->created_by_user_id));
            array_push($results, $temp_data);
        }
        return $results;
    }

    // public function getBanks(Practice $practice)
    // {
    //     // TODO: Implement getBanks() method.
    //     $results = array();
    //     $account_holders = $practice->banks()->get();
    //     $banks = DB::table('product_practice_banks')
    //         ->where('practice_id', $practice->id)
    //         ->get();
    //     //Log::info($account_holders);
    //     foreach ($banks as $bank) {
    //         $banker = ProductBank::find($bank->product_bank_id);
    //         $banker_branch = ProductBankBranch::find($bank->product_bank_branch_id);
    //         //            Log::info($bank);
    //         //            Log::info($banker);
    //         //            Log::info($banker_branch);
    //         $temp_data['id'] = $bank->uuid;
    //         $temp_data['bank_id'] = $banker->uuid;
    //         $temp_data['bank_branch_id'] = $banker_branch->uuid;
    //         $temp_data['bank_name'] = $banker->bank_name;
    //         $temp_data['account_name'] = 'AMREF AFRICA'; //$bank->account_name;
    //         $temp_data['account_number'] = $bank->account_number;
    //         $temp_data['branch_name'] = $banker_branch->branch_name;
    //         $temp_data['branch_code'] = $banker_branch->branch_code;
    //         $temp_data['state'] = 'Kenya';
    //         array_push($results, $temp_data);
    //     }
    //     return $results;
    // }

    public function getPurchases(Model $model,$pagination=10)
    {
        // TODO: Implement getPurchases() method.
        //$results = array();
        //$sorted = Model::orderBy('name')->paginate(10);
        //return $purchases = $model->purchases()->get()->sortByDesc('created_at');
        return $model->purchases()->orderBy('created_at')->paginate(15);
        // foreach ($purchases as $purchase) {
        //     array_push($results, $this->transform_purchase($purchase));
        // }
        // return $results;
    }

    public function createPrice($practice_product_item_id, $practice_id, $unit_cost, $unit_retail_price, $pack_cost, $pack_retail_price, $user_id = null)
    {
        // TODO: Implement createPrice() method.
        $price = ProductPriceRecord::all()
            ->where('practice_product_item_id', $practice_product_item_id)
            ->where('practice_id', $practice_id)
            ->where('unit_cost', $unit_cost)
            ->where('unit_retail_price', $unit_retail_price)
            ->where('pack_cost', $pack_cost)
            ->where('pack_retail_price', $pack_retail_price)
            ->first();
        if ($price) {
            return $price;
        } else {
            return ProductPriceRecord::create([
                'practice_product_item_id' => $practice_product_item_id,
                'practice_id' => $practice_id,
                'unit_cost' => $unit_cost,
                'unit_retail_price' => $unit_retail_price,
                'pack_cost' => $pack_cost,
                'pack_retail_price' => $pack_retail_price,
                'created_by_user_id' => $user_id,
            ]);
        }
    }


    public function transform_purchase(ProductPurchase $productPurchase)
    {
        // TODO: Implement transform_purchase() method.
        return [
            'trans_id' => $productPurchase->id,
            'id' => $productPurchase->uuid,
            'bill_no' => $productPurchase->bill_no,
            'status' => $productPurchase->status,
            'discount_offered' => $productPurchase->discount_offered,
            'note' => $productPurchase->note,
            'payment_date' => date("Y-m-d"), //$productPurchase->payment_date
            'created_at' => $this->helper->format_mysql_date($productPurchase->created_at),
            'total' => $this->getPurchaseData($productPurchase, 'total'),
            'grand_total' => $this->getPurchaseData($productPurchase, 'grand_total'),
            'cash_paid' => $this->getPurchaseData($productPurchase, 'cash_paid'),
            'balance' => $this->getPurchaseData($productPurchase, 'balance'),
            // 'payment_method' => $this->getPurchaseData($productPurchase, 'payment_method'),
            'payment_method' => $productPurchase->payment_types()->get()->first()->name,
            'supplier' => $this->getPurchaseData($productPurchase, 'supplier'),
            'items' => $this->getPurchaseData($productPurchase, 'items'),
        ];
    }

    public function getPurchaseData(Model $productPurchase, $type)
    {
        // TODO: Implement getTotal() method.
        switch ($type) {

            case "total":
                $items = $productPurchase->items()->get();
                $total = 0;
                foreach ($items as $item) {
                    //item price
                    $price = $item->prices()->get()->first();
                    $total += $item->qty * $price->pack_cost;
                }
                return $total;
                break;

            case "cash_paid":
                return $productPurchase->payments()->get()->sum('cash_paid');
                break;

            case "balance":
                $items = $productPurchase->items()->get();
                $total = 0;
                $bal = 0;
                foreach ($items as $item) {
                    $price = $item->prices()->get()->first();
                    $total += $item->qty * $price->pack_cost;
                }
                if ($productPurchase->discount_offered > 0) {
                    $disc = ($productPurchase->discount_offered / 100) * $total;
                }
                $paid = $productPurchase->payments()->get()->sum('cash_paid');
                $bal = $total - $disc - $paid;
                return $bal;
                break;

            case "grand_total":
                $items = $productPurchase->items()->get();
                $total = 0;
                $bal = 0;
                foreach ($items as $item) {
                    $price = $item->prices()->get()->first();
                    $total += $item->qty * $price->pack_cost;
                }
                if ($productPurchase->discount_offered > 0) {
                    $disc = ($productPurchase->discount_offered / 100) * $total;
                    $bal = $total - $disc;
                } else {
                    $bal = $total;
                }
                return $bal;
                break;
            case "supplier":
                $supplier = $productPurchase->suppliers()->get()->first();
                if($supplier){
                    return [
                        'id' => $supplier->uuid,
                        'first_name' => $supplier->first_name,
                        'other_name' => $supplier->other_name,
                        'company' => $supplier->company,
                        'logo' => $supplier->logo,
                        'phone' => $supplier->phone,
                        'email' => $supplier->email,
                        'mobile' => $supplier->mobile,
                        'fax' => $supplier->fax,
                        'address' => $supplier->address,
                    ];
                }else{
                    return [];
                }
                break;
            case "items":
                $results = array();
                $items = $productPurchase->items()->get();
                foreach ($items as $item) {
                    $practice_product_item = $item->practice_product_item()->get()->first();
                    $item_data = $this->helper->create_product_attribute($practice_product_item);
                    $product = Product::find($practice_product_item->product_id);
                    $price = $item->prices()->get()->first();
                    // $temp_data['id'] = $item->uuid;
                    // $temp_data['trans_id'] = $item->id;
                    // $temp_data['qty'] = $item->qty;
                    // $temp_data['name'] = $product->name;
                    // $temp_data['pack_cost'] = $price->pack_cost;
                    // $temp_data['total'] = $item->qty * $price->pack_cost;
                    $item_data['trans_id'] = $item->id;
                    $item_data['id'] = $item->uuid;
                    $item_data['qty'] = $item->qty;
                    $item_data['name'] = $product->name;
                    $item_data['pack_cost'] = $price->pack_cost;
                    $item_data['total'] = $item->qty * $price->pack_cost;
                    array_push($results, $item_data);
                }
                return $results;
                break;
        }
    }

    public function double_entry_handler(Practice $practice, $trans_type, $amount, $narration, $trans_date, $credited_account = null, $debited_account = null, $inputs)
    {
        // TODO: Implement double_entry_handler() method.
        $inputs['narration'] = $narration;
        $inputs['amount'] = $amount;
        $inputs['v_date'] = $trans_date;
        $inputs['v_date'] = $trans_date;
        $inputs['created'] = $trans_date;
        switch ($trans_type) {
            case Product::DEBIT:
                $inputs['debited_account'] = $debited_account;
                break;
            case Product::CREDIT:
                $inputs['credited_account'] = $debited_account;
                break;
        }
        return $practice->vouchers()->create($inputs);
    }

    public function setCOA(Practice $practice, ProductAccountType $productAccountType, ProductAccountDetailType $productAccountDetailType, array $inputs)
    {
        // TODO: Implement setCOA() method.
        $resp = $this->helper->msg();
        switch ($productAccountDetailType->name) {
            case ProductAccountDetailType::OPENING_BALANCE_EQUITY:
                //check if this practice has this account
                $op_account = $practice->chart_accounts()->where('account_detail_type_id', $productAccountDetailType->id)->get()->first();
                if ($op_account) {
                    $resp['message'] = "There can be only one account of detail type Opening Balance Equity.";
                } else {
                    $inputs['account_type_id'] = $productAccountType->id;
                    $inputs['account_detail_type_id'] = $productAccountDetailType->id;
                    $inputs['account_number'] = strtoupper($this->helper->getToken(8));
                    $op_account = $practice->chart_accounts()->create($inputs);
                    $resp['status'] = true;
                    $resp['message'] = "Created successful!";
                }
                break;
            case "Thhis":

                break;
            default: //Double entry of type deposit
                $inputs['account_type_id'] = $productAccountType->id;
                $inputs['account_detail_type_id'] = $productAccountDetailType->id;
                $inputs['account_number'] = strtoupper($this->helper->getToken(8));
                $op_account = $practice->chart_accounts()->create($inputs);
                //check if balance is > 0
                if ($inputs['balance'] > 0) {
                    //get the Opening balance equity details
                    $account_type_details = ProductAccountDetailType::all()->where('name', ProductAccountDetailType::OPENING_BALANCE_EQUITY)->first();
                    $practice_account = $practice->chart_accounts()->get()->where('account_detail_type_id', $account_type_details->id)->first();
                    $inputs['credited_account'] = $practice_account->account_number;
                    $inputs['debited_account'] = $op_account->account_number;
                    $inputs['trans_type'] = "Deposit";
                    //$voucher['narration'] = $practice_account->account_number;
                    //$voucher['balance'] = $practice_account->account_number;
                    $inputs['v_date'] = $inputs['as_at'];
                    $practice->vouchers()->create($inputs);
                }
                $resp['status'] = true;
                $resp['message'] = "Created successful!";
                break;
        }
        return $resp;
    }

    public function getBalance(ProductChartAccount $productChartAccount)
    {
        // TODO: Implement getBalance() method.
        return $productChartAccount->credited()->get()->sum('balance');
        //return $productChartAccount->credited()->get()->sum(ProductChartAccount::CREDITED_ACCOUNT);
        //return ProductVoucher::all()->sum(ProductChartAccount::CREDITED_ACCOUNT);
    }
}

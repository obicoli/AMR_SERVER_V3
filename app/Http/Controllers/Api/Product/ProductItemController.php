<?php

namespace App\Http\Controllers\Api\Product;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\helpers\HelperFunctions;
use App\Manufacturer\Repository\ManufacturerRepository;
//use App\Models\Manufacturer\Manufacturer;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
// use App\Models\Practice\PracticeProductItemStock;
use App\Models\Practice\Taxation\PracticeTaxation;
use App\Models\Product\Product;
use App\Models\Product\ProductAdministrationRoute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductBrandSector;
use App\Models\Product\ProductCategory;
// use App\Models\Product\ProductCurrency;
use App\Models\Product\ProductGeneric;
use App\Models\Product\ProductType;
use App\Models\Product\ProductUnit;
//use App\Repositories\Manufacturer\ManufacturerRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Hospital\Hospital;
use App\Models\Module\Module;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\ProductItem;
use App\Models\Product\Sales\ProductPriceRecord;
use \App\Manufacturer\Models\Manufacturer;

class ProductItemController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $productItem;
    protected $product;
    protected $generic;
    protected $item_type;
    protected $brands;
    protected $brandSectors;
    protected $item_category;
    protected $unit_measure;
    protected $practice;
    protected $product_routes;
    protected $accountsChartAccounts;
    protected $accountsVouchers;
    protected $product_prices;
    protected $product_stock_inwards;
    protected $taxations;
    protected $manufacturers;
    protected $STOCK_SOURCE_OPENING_STOCK;

    public function __construct(ProductItem $productItem)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productItem = new ProductReposity($productItem);
        $this->product = new ProductReposity(new Product());
        $this->generic = new ProductReposity(new ProductGeneric());
        $this->item_type = new ProductReposity(new ProductType());
        $this->brands = new ProductReposity(new ProductBrand());
        $this->brandSectors = new ProductReposity( new ProductBrandSector() );
        $this->item_category = new ProductReposity(new ProductCategory());
        $this->unit_measure = new ProductReposity(new ProductUnit());
        $this->practice = new PracticeRepository(new Practice());
        $this->product_routes = new ProductReposity(new ProductAdministrationRoute());
        $this->accountsChartAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->accountsVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->product_prices = new ProductReposity( new ProductPriceRecord() );
        $this->product_stock_inwards = new ProductReposity( new ProductStockInward() );
        $this->taxations = new ProductReposity( new PracticeTaxation() );
        $this->manufacturers = new ManufacturerRepository( new Manufacturer() );
        $this->STOCK_SOURCE_OPENING_STOCK = AccountsCoa::STOCK_SOURCE_OPENING_STOCK;
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $practiceMain = $this->practice->findParent($company);
        $product_items = $practiceMain->product_items()->orderByDesc('created_at')->paginate(10);
        $paged_data = $this->helper->paginator($product_items);
        foreach($product_items as $product_item){
            array_push($results,$this->productItem->transform_product_item($product_item,$company));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $company = $this->practice->find($request->user()->company_id);
        $product_item = $this->productItem->findByUuid($uuid);
        $http_resp['results'] = $this->productItem->transform_product_item($product_item,$company);
        return response()->json($http_resp);
    }

    public function create(Request $request){

        //Log::info($request);
        $http_resp = $this->response_type['200'];
        $company = $this->practice->find($request->user()->company_id);
        $owner = $this->practice->findParent($company);

        $validation = Validator::make($request->all(),[
            'item_name' => 'required',
            'item_code' => 'required',
            'brand_id' => 'required',
            'brand_sector_id' => 'required',
            'manufacturer_id' => 'required',
            'unit_cost' => 'required',
            'unit_retail_price' => 'required',
            'pack_retail_price' => 'required',
            'pack_cost' => 'required',
            'status' => 'required',
            'uom_id' => 'required',
            'single_unit_weight' => 'required',
            'alert_indicator_level' => 'required',
        ],$this->helper->messages());

        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        $brand = $this->brands->findByUuid($request->brand_id);
        $brand_sector = $this->brandSectors->findByUuid($request->brand_sector_id);
        $manufacturer = $this->manufacturers->findByUuid($request->manufacturer_id);
        $uom = $this->unit_measure->findByUuid($request->uom_id);
        $company_vat_type = $this->taxations->findByUuid($request->vat_type_id);

        $inputs = $request->all();
        $inputs['product_brand_id'] = $brand->id;
        $inputs['product_brand_sector_id'] = $brand_sector->id;
        $inputs['manufacturer_id'] = $manufacturer->id;
        $inputs['product_manufacturer_id'] = $manufacturer->id;
        $inputs['product_unit_id'] = $uom->id;
        //Check if item exist
        if( $this->productItem->isInventoryItemExist($inputs) ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Inventory item already exist'];
            return response()->json($http_resp,422);
        }

        if( $owner->product_items()->where('item_code',$request->item_code)->get()->first() ){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = ['Item code already in use!'];
            return response()->json($http_resp,422);
        }

        if ( $request->opening_qty > 0 ){
            $validation = Validator::make($request->all(),[
                'as_of' => 'required',
                'purchase_account_id' => 'required',
                'sales_account_id' => 'required',
            ],$this->helper->messages());
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try {

            $as_of = $this->helper->format_lunox_date($request->as_of);
            //Create new Product Item
            $new_product_item = $owner->product_items()->create($inputs);
            //Link it to VAT
            if ( $company_vat_type ){
                $item_tax = $new_product_item->taxations()->save($company_vat_type);
            }

            //Link it to price list
            $price['unit_cost'] = $request->unit_cost;
            $price['unit_retail_price'] = $request->unit_retail_price;
            $price['pack_cost'] = $request->pack_cost;
            $price['pack_retail_price'] = $request->pack_retail_price;
            $dbprice = $this->product_prices->createPrice($new_product_item->id,$company->id,$price['unit_cost'],$price['unit_retail_price'],
                $price['pack_cost'],$price['pack_retail_price'],$request->user()->id);

            //Accounting occur if opening balance is provided
            if ( $request->opening_qty > 0 ){

                $trans_name = $this->STOCK_SOURCE_OPENING_STOCK;
                $purchase_ledger_ac = $this->accountsChartAccounts->findByUuid($request->purchase_account_id);
                $ownerEquityAc = $this->accountsChartAccounts->getOwnerEquityAccount($company);
                //Create Open Balance and Link it
                $qty = $request->opening_qty;
                $pack_cost = $request->pack_cost;
                $amount = $qty * $pack_cost;
                $open_balance_inputs['reason'] = $trans_name;
                $open_balance_inputs['amount'] = $amount;
                $open_balance_obj = $company->accountOpeningBalances()->create($open_balance_inputs);
                $open_balance_obj = $new_product_item->openingBalances()->save($open_balance_obj);

                //VAT Type Ledger Entry
                if($company_vat_type){
                    $company_vat_type_ledger_ac = $company_vat_type->ledger_accounts()->get()->first();
                    $taxes = array();
                    $converted_tax = $this->practice->transformPracticeTaxation($company_vat_type);
                    array_push($taxes,$converted_tax);
                    $prices_after_tax = $this->helper->taxation_calculation($price,$taxes);
                    $taxed_amount = $qty * $prices_after_tax['pack_cost'];
                    $vat_amount = $amount - $taxed_amount;
                    //
                    $debited_ac = $purchase_ledger_ac->code;
                    $credited_ac = $company_vat_type_ledger_ac->code;
                    $transaction_id = $this->helper->getToken(10,'INVAT');
                    $supportDocument = $open_balance_obj->double_entry_support_document()->create(['trans_type'=>$this->STOCK_SOURCE_OPENING_STOCK]);
                    $double_entry = $this->accountsVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$vat_amount,$as_of,$trans_name,$transaction_id);
                    $double_entry->supports()->save($supportDocument);
                    $amount = $taxed_amount;
                }

                //Inventory Ledger Entry
                $debited_ac = $purchase_ledger_ac->code;
                $credited_ac = $ownerEquityAc->code;
                $transaction_id = $this->helper->getToken(10,'INV');
                $supportDocument = $open_balance_obj->double_entry_support_document()->create(['trans_type'=>$this->STOCK_SOURCE_OPENING_STOCK]);
                $double_entry = $this->accountsVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_of,$trans_name,$transaction_id);
                $double_entry->supports()->save($supportDocument);

                //Update Inventory
                $inputs_stock['amount'] = $qty;
                $inputs_stock['product_item_id'] = $new_product_item->id;
                $inputs_stock['product_price_id'] = $dbprice->id;
                $inputs_stock['source_type'] = $this->STOCK_SOURCE_OPENING_STOCK;
                $product_stock = $company->product_stocks()->create($inputs_stock);
                //If Inventory Tracking is Enabled Capture Barcode and Batches
                $inputs_stock_inw = [];
                $stock_inward = $product_stock->stock_inwards()->create($inputs_stock_inw);

            }

        }catch (\Exception $e){
            $http_resp = $this->response_type['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        return response()->json($http_resp);
    }


    public function update(Request $request,$uuid){

        Log::info($request);
        $http_resp = $this->response_type['200'];
        $rule = [
            //'initial_stock'=>'required',
            'price' => 'required'
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }
        //
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->beginTransaction();
        try{
            //Find Product Item
            $product_item = $this->productItem->findByUuid($uuid);
            $company = $this->practice->find($request->user()->company_id);
            if( $request->initial_stock > 0 ){

                $rule = [ 'inventory'=>'required','as_of'=>'required' ];
                $validation = Validator::make($request->all(),$rule,$this->helper->messages());
                if ($validation->fails()){
                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                    DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
                    $http_resp = $this->response_type['422'];
                    $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                    return response()->json($http_resp,422);
                }

                //Find Inventory Account to be debited
                $inventory_account = $this->accountsChartAccounts->findByUuid($request->inventory['id']);
                //Find Company's Owners Equity Account by Code which is to be credited
                $owner_equity_account = $company->chart_of_accounts()->where('default_code',AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE)->get()->first();
                //Calculate amount of stock in Cash
                $stock_cash = $request->initial_stock * $request->price['pack_retail_price'];
                //Find the price
                //Here system can also create new price if user edited 
                $db_price = $this->product_prices->findByUuid($request->price['id']);
                
                //1. Save company's product stock inward and attach it to product item as below
                //1. Stock source_type is Opening Stock
                $inputs = $request->all();
                $inputs['amount'] = $request->initial_stock;
                $inputs['product_item_id'] = $product_item->id;
                $inputs['product_price_id'] = $db_price->id;
                $inputs['source_type'] = Product::STOCK_SOURCE_OPENING_STOCK;
                $stock_inward = $company->product_stock_inward()->create($inputs);
                //0. Accounting Transaction
                //1. Selected Inventory Account will debited
                //2. By default Owner's Equity account will be credited
                $debited_ac = $inventory_account->code;
                $credited_ac = $owner_equity_account->code;
                $amount = $stock_cash;
                $as_at = $request->as_of;
                $trans_name = AccountsCoa::TRANS_NAME_OPEN_BALANCE;
                $trans_type = AccountsCoa::TRANS_NAME_OPEN_BALANCE;
                $transaction_id = $this->helper->getToken(AccountsCoa::TRANS_ID_LENGTH);
                $account_number = $product_item->item_code;
                $reference_number = $product_item->item_code;
                $double_entry = $this->accountsVouchers->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
                $support_doc = $product_item->double_entry_support_document()->create(['trans_type'=>$trans_type,'trans_name'=>$trans_name,'account_number'=>$account_number,'voucher_id'=>$double_entry->id,'reference_number'=>$reference_number]);
                // $double_entry = $this->accountsVouchers->accounts_double_entry($company,$inventory_account->code,$owner_equity_account->code,$stock_cash,$request->as_of,AccountsCoa::TRANS_TYPE_START,$transaction_id);
                // $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_START,'trans_name'=>AccountsCoa::TRANS_NAME_INVENTORY_OP_STOCK]);
            }

            //Start by reseting all taxations on this product
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_item_taxations')->where('product_item_id',$product_item->id)->delete();
            //Process taxation attachment if user attached taxe rates that were not attached before
            //1. ProductItems Table : TaxationTaxation Table is a Many:Many relationship
            //2. Connection Table:"product_item_taxations", ProductID: "product_item_id", TaxationID: "product_taxation_id"
            $tax_rates = $request->taxes;
            for ($i=0; $i < sizeof($tax_rates); $i++) { 
                //Find tax by uuid
                $taxed = $this->taxations->findByUuid($tax_rates[$i]['id']);
                //check if Product Item is not attached to this taxe and attach it
                if( !DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->table('product_item_taxations')->where('product_item_id',$product_item->id)->where('product_taxation_id',$taxed->id)->get()->first() ){
                    //$new_taxation = $product_item->taxations()->save($taxed);
                    $inps['product_item_id'] = $product_item->id;
                    $inps['product_taxation_id'] = $taxed->id;
                    DB::connection(Module::MYSQL_PRODUCT_DB_CONN)
                    ->table('product_item_taxations')->insert($inps);
                }
                // Log::info("============================");
                // Log::info($taxed);
                // Log::info("============================");
            }
            
        }catch(\Exception $e){
            $http_resp = $this->response_type['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_PRODUCT_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}

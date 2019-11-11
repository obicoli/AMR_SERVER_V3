<?php

namespace App\Http\Controllers\Api\Product;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
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
use App\Models\Module\Module;
use App\Models\Product\Inventory\Inward\ProductStockInward;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;

class ProductItemController extends Controller
{
    protected $response_type;
    protected $helper;
    protected $productItem;
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
    protected $accountsChartAccounts;
    protected $accountsVouchers;
    protected $product_prices;
    protected $product_stock_inwards;
    protected $taxations;

    public function __construct(ProductItem $productItem)
    {
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->productItem = new ProductReposity($productItem);
        $this->product = new ProductReposity(new Product());
        $this->generic = new ProductReposity(new ProductGeneric());
        $this->manufacturer = new ManufacturerRepository(new Manufacturer());
        $this->item_type = new ProductReposity(new ProductType());
        $this->brands = new ProductReposity(new ProductBrand());
        $this->item_category = new ProductReposity(new ProductCategory());
        $this->unit_measure = new ProductReposity(new ProductUnit());
        $this->practice = new PracticeRepository(new Practice());
        $this->product_routes = new ProductReposity(new ProductAdministrationRoute());
        //$this->product_currency = new ProductReposity(new ProductCurrency());
        $this->accountsChartAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->accountsVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->product_prices = new ProductReposity( new ProductPriceRecord() );
        $this->product_stock_inwards = new ProductReposity( new ProductStockInward() );
        $this->taxations = new ProductReposity( new ProductTaxation() );
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $practiceMain = $this->practice->findParent($company);
        $product_items = $practiceMain->product_items()->orderByDesc('created_at')->paginate(15);
        $paged_data = $this->helper->paginator($product_items);
        foreach($product_items as $product_item){
            array_push($results,$this->productItem->transform_product_item($product_item,$company));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }

    public function all_list(Request $request){
        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $practiceMain = $this->practice->findParent($company);
        $product_items = $practiceMain->product_items()->orderByDesc('created_at')->paginate(15);
        //$product_items = $practiceMain->product_items()->orderByDesc('created_at')->get();
        foreach($product_items as $product_item){
            array_push($results,$this->productItem->transform_product_item($product_item,$company));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){

        Log::info($request);
        $http_resp = $this->response_type['200'];
        $rule = [
            'initial_stock'=>'required',
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
                //Accounting Transaction
                //1. Selected Inventory Account will debited
                //2. By default Owner's Equity account will be credited
                $transaction_id = $this->helper->getToken(AccountsCoa::TRANS_ID_LENGTH);
                $double_entry = $this->accountsVouchers->accounts_double_entry($company,$inventory_account->code,$owner_equity_account->code,$stock_cash,$request->as_of,AccountsCoa::TRANS_TYPE_START,$transaction_id);
                $support_doc = $double_entry->support_documents()->create(['trans_type'=>AccountsCoa::TRANS_TYPE_START,'trans_name'=>AccountsCoa::TRANS_NAME_INVENTORY_OP_STOCK]);
            }

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
                Log::info("============================");
                Log::info($taxed);
                Log::info("============================");
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
        //Transform the updated product Item and return it back
        //$http_resp['results'] = $this->productItem->transform_product_item($this->productItem->findByUuid($uuid),$company);
        return response()->json($http_resp);
    }

}

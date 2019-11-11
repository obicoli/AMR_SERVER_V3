<?php


namespace App\Repositories\Product;


use App\Models\Practice\Practice;
use App\Models\Practice\PracticeProductItem;
use App\Models\Product\Accounts\ProductAccountDetailType;
use App\Models\Product\Accounts\ProductAccountType;
use App\Models\Product\Accounts\ProductChartAccount;
use App\Models\Product\Purchase\ProductPurchase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\ProductStock;
use App\Models\Product\ProductItem;
use App\Models\Product\ProductTaxation;
use App\Models\Product\Sales\ProductPriceRecord;

interface ProductReposityInterface
{
    //Retrieving or Creating Product Attribute
    public function getOrCreateAttributes($attr=[]);

    public function all();
    public function create(array $arr);
    public function destroy($id);
    public function find($id);
    public function findByUuid($uuid);
    public function findByName($name);
    public function getName($id);
    public function getPrices($id,$type);
    public function update(array $arr, $id);
    //
    public function transform_taxation(ProductTaxation $productTaxation);
    public function transform_price(ProductPriceRecord $productPriceRecord);
    public function transform_product_item(ProductItem $productItem,Practice $practice=null);
    public function transform_($collections);
    public function transform_collection($collection);
    public function createSale(Practice $practice, array $arr);
    public function createPurchase(Practice $practice, array $arr);
    public function getCategories(Practice $practice = null);
    public function getUnits(Practice $practice = null);
    public function getTypes(Practice $practice = null);
    public function getGenerics(Practice $practice = null);
    public function getBrands(Practice $practice = null);
    public function getBrandSector(Practice $practice = null);
    public function getAttributes(Practice $practice, $attribute_type = null);
    public function getProducts(Practice $practice = null);
    public function getTax(Practice $practice, PracticeProductItem $practiceProductItem = null);
    public function getStores(Model $model, $type=null);
    public function getRoutes(Model $model = null, $type=null);
    public function getVaccines(Model $model = null, $type=null);
    public function getFormulations(Model $model = null, $type=null);
    public function getProductProfile(Model $model = null, $type=null);
    public function getProductTypes(Model $model = null, $type=null);
    public function getOrCreate($name);
    

    //getAttributes
    //
    //practice product item sales charge
    public function getItemSalesCharge(Practice $practice);
    //check if code is in use
    public function findByCode(Model $model, $code);
    public function findByItemCode($code);
    //Product
    public function checkExistence(array $arr);
    public function setProductItem(Model $model, array $arr);
    public function setTax(Model $model, array $arr);
    public function setProductType(Model $model, array $arr);
    public function getProductItem(Practice $practice, array $filters = []);
    public function setProductItemPrice(ProductItem $practiceProductItem, $prices);
    //public function transform_product_item(ProductItem $practiceProductItem, $source=null,Practice $practice=null,$parentPractice=null);
    public function getStock(PracticeProductItem $practiceProductItem);
    public function sumStocks(ProductStock $productStock);
    //account holders
    public function getAccountHolders(Practice $practice);
    //public function getBanks(Practice $practice);
    //purchases
    public function getPurchases(Model $model,$pagination=10);
    public function createPrice($practice_product_item_id,$practice_id,$unit_cost,$unit_retail_price,$pack_cost,$pack_retail_price,$user_id = null);
    public function transform_purchase(ProductPurchase $productPurchase);
    public function getPurchaseData(Model $productPurchase, $type);
    public function double_entry_handler(Practice $practice,$trans_type,$amount,$narration,$trans_date,$credited_account=null,$debited_account=null,$inputs);
    //COA
    public function setCOA(Practice $practice, ProductAccountType $productAccountType, ProductAccountDetailType $productAccountDetailType, array $inputs);
    public function getBalance(ProductChartAccount $productChartAccount);


}
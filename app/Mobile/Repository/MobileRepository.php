<?php

namespace App\Mobile\Repository;

use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Product\Product;
use App\Models\Product\Store\ProductStore;
use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use Illuminate\Support\Facades\Log;

class MobileRepository implements MobileRepositoryInterface{

    protected $model;
    protected $helper;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->helper = new HelperFunctions();
    }

    public function transformUser(User $user){
        $accounts = null;
        $practiceRepository = new PracticeRepository( new Practice() );
        $productRepository = new ProductReposity( new Product() );
        $practice_account = $user->practiceUsers()->where('practice_id',$user->getCompanyId())->get()->first();
        if($practice_account){
            $company = Practice::find($user->getCompanyId());
            $head_quarter = $company->owner()->get()->first();
            //Log::info($head_quarter);
            $accounts = $practiceRepository->transform_user($practice_account);
            //
            $facility = $practiceRepository->transform_company($company);
                $store = ProductStore::find($user->getStoreId());
                $store_data = $productRepository->transform_store($store);
                $product_items = $head_quarter->product_items()->paginate(20);
                $products = array();
                $paged_product = $this->helper->paginator($product_items);
                foreach($product_items as $product_item){
                    $item = $productRepository->transform_product_item($product_item);
                    $item_mobile['id'] = $item['id'];
                    $item_mobile['name'] = $item['item_name']['name'];
                    $item_mobile['type'] = $item['item_type']['name'];
                    $item_mobile['category'] = $item['category']['name'];
                    $item_mobile['stock'] = $item['stock'];
                    array_push($products,$item_mobile);
                }
                $paged_product['data'] = $products;

                $store_data['products'] = $paged_product;
            $facility['store'] = $store_data;
            //
            $accounts['facility'] = $facility;
        }
        return $accounts;
    }

}
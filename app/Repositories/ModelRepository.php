<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 9:27 PM
 */

namespace App\Repositories;


use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Product\ProductCategory;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModelRepository implements ModelRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($_PAGINATE = 0, $_SORT_ORDER = null)
    {
        // TODO: Implement all() method.
        return $this->model->orderByDesc('created_at')->paginate(20);
    }

    public function store(array $arr)
    {
        // TODO: Implement store() method.
        return $this->model->create($arr);
    }

    public function update(array $arr, $uuid)
    {
        // TODO: Implement update() method.
        return $obj = $this->model->all()->where('uuid',$uuid)->first()->update($arr);
    }

    public function destroy($uuid)
    {
        // TODO: Implement destroy() method.
        return $obj = $this->model->all()->where('uuid',$uuid)->first()->delete();
    }

    public function find($id)
    {
        // TODO: Implement find() method.
        return $this->model->find($id);
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $obj = $this->model->all()->where('uuid',$uuid)->first();
    }

    public function getName($id, $slug = null)
    {
        // TODO: Implement getName() method.
        if ($id){
            if ($slug){
                return $this->model->find($id)->slug;
            }else{
                return $this->model->find($id)->name;
            }
        }else{
            return null;
        }
    }

    public function search($search_params, $type, Model $model = null)
    {
        // TODO: Implement search() method.
        $pactRepo = new PracticeRepository(new Practice());
        $results = null;
        switch ($type){
            case "pharmacy":
                $results = $this->model->where('country', 'like', '%' . $search_params['country'] . '%')
                    ->orWhere('city', 'like', '%' . $search_params['city'] . '%')
                    ->orWhere('country', 'like', '%' . $search_params['country'] . '%')
                    ->where('approval_status', 'approved')
                    ->where('type', 'Pharmacy')
                    ->orderByDesc('id')
                    ->get();
                break;
            case "conditions":
            case "medications":
            case "allergies":
            case "surgeries":
            case "departments":
            case "products":
            case "generics":
            case "manufacturers":
            $results = $this->model->where('name', 'like', '%' . $search_params['name'] . '%')
                ->orderBy('name')
                ->get();
                break;
            case "product_name":
            case "product_generic":
            $results = $this->model->where('name', 'like', '%' . $search_params['name'] . '%')
                ->where('practice_id',$search_params['practice_id'])
                ->orderBy('name')
                ->get();
                break;
            case "Brand Sector":
                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $parentPractice = $pactRepo->findParent($practice);
                $practice = $pactRepo->findOwner($practice);
                $results = $parentPractice->product_brand_sector()->where('name', 'like', '%' . $search_params['name'] . '%')
                    ->orderBy('name')
                    ->paginate(10);
            break;
            case "UOM":
                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $parentPractice = $pactRepo->findParent($practice);
                $results = $parentPractice->product_units()->where('name', 'like', '%' . $search_params['name'] . '%')
                    ->orderBy('name')
                    ->paginate(10);
            break;
            case "Brands":
            //case "drug_categories":
                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $parentPractice = $pactRepo->findParent($practice);
                //$practice = $pactRepo->findOwner($practice);
                $results = $parentPractice->product_brands()->where('name', 'like', '%' . $search_params['name'] . '%')
                    ->orderBy('name')
                    ->paginate(10);
            break;
            case "HR":
                $results = $this->model->where('name', 'like', '%' . $search_params['name'] . '%')
                    ->where('description', '=', 'HR')
                    ->orderBy('name')
                    ->get();
                break;
            case "item_code":

                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $results = $this->model->where('item_code',$search_params['name'])
                    ->where('practice_id', $practice->id)
                    ->get()->first();
                break;
            case "barcode":
                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $results = $this->model->where('barcode',$search_params['name'])
                    ->where('practice_id', $practice->id)
                    ->get()->first();
                break;
            case "Category":
                $results = $model->product_category()->where('name', 'like', '%' . $search_params['name'] . '%')
                ->orWhere('description', 'like', '%' . $search_params['name'] . '%')
                ->paginate(10);
                break;
            case "Sub Category":
                $results = $model->product_sub_category()->where('name', 'like', '%' . $search_params['name'] . '%')
                ->orWhere('description', 'like', '%' . $search_params['name'] . '%')
                ->paginate(10);
                break;
            case "practice_product_item":

                $practice = $pactRepo->findByUuid($search_params['practice_id']);
                $parentPractice = $pactRepo->findParent($practice);
                $results = DB::table('products')
                    ->join('product_items','products.id','=','product_items.product_id')
                    ->select('product_items.*', 'products.name')
                    ->where('product_items.owner_id',$parentPractice->id)
                    ->where('product_items.owner_type',$practice->owner_type)
                    ->where('products.name', 'like', '%' . $search_params['name'] . '%')
                    ->orWhere('product_items.item_code', 'like', '%' . $search_params['name'] . '%')
                    //->orWhere('product_items.barcode', 'like', '%' . $search_params['name'] . '%')
                    ->get()->sortByDesc('created_at');
                //$results = $practice->product_items()->get()->sortByDesc('created_at');
                break;
        }

        return $results;

    }

    public function transform_collection($collections)
    {
        // TODO: Implement transform_collection() method.
        $results = array();
        foreach ( $collections as $collection){
            $temp_data['id'] = $collection->uuid;
            $temp_data['name'] = $collection->name;
            $temp_data['status'] = $collection->status;
            $temp_data['slug'] = $collection->slug;
            array_push($results, $temp_data);
        }
        return $results;
    }


}
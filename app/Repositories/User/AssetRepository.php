<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/30/18
 * Time: 5:35 PM
 */

namespace App\Repositories\User;


use App\Models\Users\Assets;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AssetRepository implements AssetRepositoryInterface
{

    protected $assets;

    public function __construct(Assets $assets)
    {
        $this->assets = $assets;
    }

    public function save(Model $model, Assets $assets)
    {
        // TODO: Implement save() method.
        return $model->assets()->save($assets);
    }

    public function create(Model $model,array $arr)
    {
        // TODO: Implement create() method.
        return $model->assets()->create($arr);
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id)
    {
        // TODO: Implement find() method.
    }

    public function findByUuid($uuid)
    {
        // TODO: Implement findByUuid() method.
        return $this->assets->all()->where('uuid',$uuid)->first();
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    public function update(array $arr, $id)
    {
        // TODO: Implement update() method.
        $this->assets->find($id)->update($arr);
    }

    public function isAssetExist(Model $model, $asset_type)
    {
        // TODO: Implement isExist() method.
        if ($model->assets()->get()->where('asset_type',$asset_type)->first()){
            return true;
        }
        return false;
    }

    public function getByModel(Model $model)
    {
        // TODO: Implement getByModel() method.
        return $model->assets()->get();
    }

    public function findByUser(User $user)
    {
        // TODO: Implement findByUser() method.
        return $user->assets()->get()->first();
    }


}

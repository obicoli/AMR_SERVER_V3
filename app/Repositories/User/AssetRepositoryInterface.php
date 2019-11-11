<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/30/18
 * Time: 5:35 PM
 */

namespace App\Repositories\User;


use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Assets;

interface AssetRepositoryInterface
{

    public function save(Model $model, Assets $assets);

    public function create(Model $model,array $arr);

    public function all();

    public function find($id);

    public function findByUuid($uuid);

    public function destroy($id);

    public function update(array $arr, $id);

    public function isAssetExist(Model $model,$asset_type);

    public function getByModel(Model $model);

    public function findByUser(User $user);

}

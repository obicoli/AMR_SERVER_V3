<?php

/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 9:27 PM
 */

namespace App\Repositories\His;

use App\Models\Practice\Department;
use App\Models\Practice\PracticeUser;
use App\Models\Product\Store\ProductStore;
use Illuminate\Database\Eloquent\Model;

interface HisRepositoryInterface{
    public function all($_PAGINATE = 0, $_SORT_ORDER = null);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function find($id);
    public function findByUuid($uuid);
    public function getOrCreate(Model $owner, Model $owning,ProductStore $productStore,Department $department,ProductStore $substore, PracticeUser $practiceUser, $inputs);
}
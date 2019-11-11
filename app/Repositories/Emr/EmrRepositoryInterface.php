<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 1:27 PM
 */

namespace App\Repositories\Emr;


interface EmrRepositoryInterface
{
    public function all($_PAGINATE = 0, $_SORT_ORDER = null);
    public function store(array $arr);
    public function update(array $arr, $id);
    public function destroy($id);
    public function find($id);
    public function findByUuid($uuid);
    public function transform_collection($collections);

}
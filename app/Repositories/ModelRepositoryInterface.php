<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/28/19
 * Time: 9:28 PM
 */

namespace App\Repositories;


interface ModelRepositoryInterface
{
    public function all($_PAGINATE = 0, $_SORT_ORDER = null);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function find($id);
    public function findByUuid($uuid);
    public function getName($id, $slug = null);
    public function search( $search_params, $type);
    public function transform_collection( $collections);
}
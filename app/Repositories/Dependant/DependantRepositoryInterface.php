<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 3/1/19
 * Time: 12:12 PM
 */

namespace App\Repositories\Dependant;


use App\Models\Patient\Patient;

interface DependantRepositoryInterface
{
    public function all();
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function find($id);
    public function findByUuid($id);
    public function deleteByUuid($uuid);
    public function transform_collection($dependants);
}
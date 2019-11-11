<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/20/19
 * Time: 7:49 AM
 */

namespace App\Repositories\Subscription;


interface PlanRepositoryInterface
{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);

}
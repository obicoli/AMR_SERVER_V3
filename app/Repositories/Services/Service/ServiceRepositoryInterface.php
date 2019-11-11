<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 12/18/18
 * Time: 2:44 PM
 */

namespace App\Repositories\Services\Service;


use App\Models\Service\Service;

interface ServiceRepositoryInterface
{

    public function all();
    public function store(array $arr);
    public function destroy($uuid);
    public function update(array $arr, $uuid);
    public function find($id);
    public function getCharge(Service $service);
    public function transform_collection($collections);

}

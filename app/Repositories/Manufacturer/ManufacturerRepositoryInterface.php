<?php
/**
 * Created by IntelliJ IDEA.
 * User: collins
 * Date: 2/19/19
 * Time: 12:21 PM
 */

namespace App\Repositories\Manufacturer;


use App\Models\Manufacturer\Manufacturer;

interface ManufacturerRepositoryInterface
{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function findByName($name);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function transform_(Manufacturer $manufacturer);
    public function transform_collection($collections);

}

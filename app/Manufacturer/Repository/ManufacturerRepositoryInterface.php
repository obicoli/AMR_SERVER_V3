<?php


namespace App\Manufacturer\Repository;


interface ManufacturerRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByUuid($uuid);
}
<?php


namespace App\Repositories\Pharmacy;


use App\Models\Pharmacy\Pharmacy;

interface PharmacyRepositoryInterface
{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function findByUserId($user_id);
    public function store(array $arr);
    public function update(array $arr, $uuid);
    public function destroy($uuid);
    public function transform(Pharmacy $pharmacy);
    public function getPractices(Pharmacy $pharmacy);
    public function getAvatar(Pharmacy $pharmacy);

}
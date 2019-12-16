<?php

namespace App\Accounting\Repositories;

interface AccountingRepositoryInterface{
    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function findByCode($code);
    public function findByName($name);
    public function findByDefaultCode($code);
    public function create($inputs = []);
}
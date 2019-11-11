<?php

namespace App\Customer\Repositories;

use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Quote\Estimate;

interface CustomerRepositoryInterface{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function create($inputs = []);
    public function transform_customer(Customer $customer);
    public function transform_term(CustomerTerms $customerTerms);
    public function transform_estimate(Estimate $estimate);
}
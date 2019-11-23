<?php

namespace App\Customer\Repositories;

use App\Customer\Models\Customer;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Quote\Estimate;
use Illuminate\Database\Eloquent\Model;

interface CustomerRepositoryInterface{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function create($inputs = []);
    public function transform_customer(Customer $customer,$detailed=null);
    public function transform_term(CustomerTerms $customerTerms);
    public function transform_estimate(Estimate $estimate);
    public function company_terms_initialization(Model $company);
}
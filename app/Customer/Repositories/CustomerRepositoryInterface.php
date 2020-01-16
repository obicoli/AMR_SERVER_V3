<?php

namespace App\Customer\Repositories;

use App\Customer\Models\Customer;
use App\Customer\Models\CustomerAddress;
use App\Customer\Models\CustomerTerms;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Orders\CustomerSalesOrder;
use App\Customer\Models\Quote\Estimate;
use App\Models\Localization\Country;
use App\Models\Practice\Practice;
use Illuminate\Database\Eloquent\Model;

interface CustomerRepositoryInterface{

    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function create($inputs = []);
    public function transform_invoices(CustomerInvoice $customerInvoice);
    public function transform_sales_order(CustomerSalesOrder $customerSalesOrder);
    public function transform_customer(Customer $customer,$detailed=null);
    public function transform_address(CustomerAddress $customerAddress);
    public function transform_country(Country $country);
    public function transform_term(CustomerTerms $customerTerms);
    public function transform_estimate(Estimate $estimate);
    public function transform_items(Model $model, $transaction=[]);
    public function company_terms_initialization(Model $company);
    //public function create_reports(Practice $practice, $report_type, Customer $customer=null, $filters=[]);
}
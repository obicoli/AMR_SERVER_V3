<?php

namespace App\Supplier\Repositories;

use App\Models\Localization\Country;
use App\Supplier\Models\PurchaseOrder;
use App\Supplier\Models\Supplier;
use App\Supplier\Models\SupplierAddress;
use App\Supplier\Models\SupplierBill;
use App\Supplier\Models\SupplierCompany;
use App\Supplier\Models\SupplierTerms;
use Illuminate\Database\Eloquent\Model;

interface SupplierRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByUuid($uuid);
    public function findByTransNumber($trans_number);
    public function create($inputs = []);
    public function transform_supplier(Supplier $supplier, $detailed=null);
    public function transform_address(SupplierAddress $supplierAddress);
    public function transform_company(SupplierCompany $supplierCompany);
    public function transform_country(Country $country);
    public function transform_term(SupplierTerms $supplierTerms);
    public function transform_purchase_order(PurchaseOrder $purchaseOrder);
    public function transform_bill(SupplierBill $supplierBill);
    public function company_terms_initializations(Model $company);
}
<?php

namespace App\Customer\Models\Invoice;

use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceTaxation extends Model
{
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_invoice_item_taxations";
    protected $fillable = [
        'customer_invoice_item_id',
        'product_taxation_id',
        'sales_rate',
        'purchase_rate',
        'collected_on_sales',
        'collected_on_purchase'
    ];
}

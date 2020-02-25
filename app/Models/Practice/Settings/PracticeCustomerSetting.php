<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeCustomerSetting extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_cust_suppl_settings";
    protected $fillable = [
        'practice_id',
        'warn_dup_reference',
        'warn_dup_invoice_number',
        'inactive_customer_processing',
        'inactive_customer_reports',
        'inactive_suppliers_processing',
        'inactive_suppliers_reports',
        'use_inclusive_suppliers_docs',
        'use_inclusive_customer_docs',
        'account_as_default_selection',
    ];

    public function getId(){ return $this->id; }
    public function getUuid(){ return $this->uuid; }
    public function getWarnDupReference(){ return $this->warn_dup_reference; }
    public function getWarnDupInvoiceNumber(){ return $this->warn_dup_invoice_number; }
    public function getInactiveCustomerProcessing(){ return $this->inactive_customer_processing; }
    public function getInactiveCustomerReport(){ return $this->inactive_customer_reports; }
    public function getInactiveSupplierProcessing(){ return $this->inactive_suppliers_processing; }
    public function getInactiveSupplierReport(){ return $this->inactive_suppliers_reports; }
    public function getUseInclusiveSupplierDocuments(){ return $this->use_inclusive_suppliers_docs; }
    public function getUseInclusiveCustomerDocuments(){ return $this->use_inclusive_customer_docs; }
    public function getUseAccountAsDefaultSelection(){ return $this->account_as_default_selection; }

    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }

}

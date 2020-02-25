<?php

namespace App;

namespace App\Models\Practice\Taxation;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Models\Practice\Practice;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeTaxVat extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_tax_vats";
    protected $fillable = [
        'collected_on_purchase',
        'collected_on_sales',
        'name',
        'description',
        'purchase_rate',
        'sales_rate',
        'status',
        'is_default',
        'practice_tax_id'
    ];


    public function getId(){ return $this->id; }
    public function getUuid(){ return $this->uuid; }
    public function getName(){ return $this->name; }
    public function getPurchaseRate(){ return $this->purchase_rate; }
    public function getSalesRate(){ return $this->sales_rate; }
    public function getIsDefault(){ return $this->is_default; }
    public function getCollectedOnPurchase(){ return $this->collected_on_purchase; }
    public function getCollectedOnSales(){ return $this->collected_on_sales; }
    public function getDescription(){ return $this->description; }
    public function getStatus(){ return $this->status; }


    public function vatSystem(){ return $this->belongsTo(PracticeTax::class,'practice_taxes_id','id'); }
    public function practiceVatTypes(){ return $this->hasMany(PracticeTaxation::class,'vat_type_id','id'); }
}

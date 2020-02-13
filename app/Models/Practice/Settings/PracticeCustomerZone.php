<?php

namespace App\Models\Practice\Settings;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;

class PracticeCustomerZone extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = "practice_customer_zones";
    protected $fillable = [
        'practice_id',
        'accounting_zone',
        'invoice_and_quotes',
    ];

    public function getUuid(){  return $this->uuid; }
    public function getAccountingZone(){  return $this->accounting_zone; }
    public function getInvoiceAndQuotes(){  return $this->invoice_and_quotes; }

    public function practices(){ return $this->belongsTo(PracticeCustomerZone::class,'practice_id','id'); }

}

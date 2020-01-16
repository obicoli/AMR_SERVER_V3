<?php

namespace App\Customer\Models;

use App\Customer\Models\Invoice\CustomerInvoice;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerTerms extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_terms";
    protected $fillable = [
        'name',
        'notes'
    ];
    public function owning(){ return $this->morphTo();} //Branch level
    public function customers(){ return $this->hasMany(Customer::class,'customer_terms_id'); }
    public function customer_invoices(){ return $this->hasMany(CustomerInvoice::class,'payment_term_id','id'); }
}

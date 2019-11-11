<?php

namespace App\Supplier\Models;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierTerms extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "supplier_terms";
    protected $fillable = [
        'name',
        'notes'
    ];

    public function owning(){ return $this->morphTo();} //Branch level
    public function suppliers(){ return $this->hasMany(Supplier::class,'payment_term_id'); }
}

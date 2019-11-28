<?php

namespace App\Supplier\Models;

use App\Models\Account\Account;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Accounting\Models\COA\AccountsHolder;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Localization\Country;

class Supplier extends Model
{
    use SoftDeletes, UuidTrait,Accountable;
    protected $connection = Module::MYSQL_SUPPLIERS_DB_CONN;
    protected $table = "suppliers";
    protected $account_type = Account::AC_SUPPLIERS;
    protected $fillable = [
        'salutation',
        'first_name',
        'last_name',
        'notes',
        'email',
        'phone',
        'mobile',
        'business_id',
        'tax_reg_number',
        'company_id',
        'currency_id',
        'display_as'
    ];

    // public function bank_transactions(){ return $this->morphMany(BankTransaction::class, 'transactionable','transactionable_type','transactionable_id'); }
    public function account_holders(){ return $this->morphMany(AccountsHolder::class, 'owner','owner_type','owner_id'); }
    public function addresses(){ return $this->hasMany(SupplierAddress::class,'supplier_id'); }
    public function currencies(){ return $this->belongsTo(Country::class,'currency_id'); }
    public function supplier_companies(){ return $this->belongsTo(SupplierCompany::class,'company_id'); }
    public function supplier_terms(){ return $this->belongsTo(SupplierTerms::class,'payment_term_id'); }
    public function bank_transactions(){
        return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id');
    }
    
}

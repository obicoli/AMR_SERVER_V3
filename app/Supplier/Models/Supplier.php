<?php

namespace App\Supplier\Models;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Models\Account\Account;
use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Localization\Country;
use App\Models\Product\ProductTaxation;

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
        'display_as',
        'payment_term_id',
        'default_vat_id',
        'old_invoice_payment_auto_locate',
        'default_discount',
        'legal_name',
        'credit_limit',
        'ledger_account_id',
        'website',
        'fax',
        'status'
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
    public function bank_accounts(){
        return $this->morphMany(AccountsBank::class,'owner','owner_type','owner_id');
    }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function ledger_accounts(){ return $this->belongsTo(AccountChartAccount::class,'ledger_account_id','id'); }
    public function vats(){ return $this->belongsTo(ProductTaxation::class,'default_vat_id','id'); }
    
}

<?php

namespace App\Customer\Models;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Quote\Estimate;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes,UuidTrait,Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customers";

    protected $fillable = [
        'city',
        'notes',
        'status',
        'first_name',
        'other_name',
        'middle_name',
        //'company',
        'postal_code',
        'country',
        'email',
        'mobile',
        'phone',
        'fax',
        'longitude',
        'latitude',
        'address',
        'prefered_payment_id',
        'payment_term_id',
        'business_id',
        'title',

        'cash_sale_customer',
        'display_as',
        'credit_limit',
        'company_id',
        'accept_electronic_invoices',
        'old_invoice_receipt_auto_locate',
        'currency_id',
        'legal_name',
        'salutation',
        'old_invoice_receipt_auto_locate',
        'accept_electronic_invoices',
        'cash_sale_customer',
        'document_sending_by',
        'default_discount',
        'default_price_id',
        'default_vat_id',
        'ledger_account_id'
    ];

    public function owning(){ return $this->morphTo();} //Branch level
    public function customer_terms(){ return $this->belongsTo(CustomerTerms::class,'customer_terms_id'); }
    public function prefered_payment(){ return $this->belongsTo(AccountPaymentType::class,'prefered_payment_id'); }
    public function account_holders(){ return $this->morphMany(AccountsHolder::class, 'owner','owner_type','owner_id'); }
    public function estimates(){ return $this->morphMany(Estimate::class, 'customer','customer_type','customer_id'); }
    public function purchase_order_shipping(){ return $this->morphMany(PurchaseOrder::class,'shipable','shipable_type','shipable_id'); }
    public function addresses(){ return $this->hasMany(CustomerAddress::class,'customer_id'); }
    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function bank_transactions(){
        return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id');
    }

    public function ledger_accounts(){ return $this->belongsTo(AccountChartAccount::class,'ledger_account_id','id'); }

}

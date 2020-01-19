<?php

namespace App\Customer\Models;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Customer\Models\Invoice\CustomerInvoice;
use App\Customer\Models\Invoice\CustomerRetainerInvoice;
use App\Customer\Models\Quote\Estimate;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Module\Module;
use App\Supplier\Models\PurchaseOrder;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPayment extends Model
{
    use SoftDeletes, UuidTrait, Accountable;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_payments";
    protected $fillable = [
        'customer_id',
        //'customer_invoice_id',
        'ledger_account_id',
        'trans_date',
        'amount',
        'status',
        'notes',
        'reference_number',
        'trans_number',
    ];

    public function customerInvoices(){
        return $this->belongsToMany(CustomerInvoice::class,'customer_invoice_payments','customer_payment_id','customer_invoice_id');
    }
    public function customerRetainerInvoices(){
        return $this->belongsToMany(CustomerRetainerInvoice::class,'customer_retainer_payments','customer_payment_id','customer_retainer_id');
    }

    public function paymentItems(){ return $this->hasMany(CustomerPaymentItem::class,'customer_payment_id','id'); }

    public function owning(){ return $this->morphTo();} //Branch level

    public function double_entry_support_document(){
        return $this->morphMany(AccountsSupport::class,'transactionable','transactionable_type','transactionable_id');
    }
    public function customers(){ return $this->belongsTo(Customer::class,'customer_id','id'); }
    public function bank_transactions(){ return $this->morphMany(BankTransaction::class,'transactionable','transactionable_type','transactionable_id'); }
}

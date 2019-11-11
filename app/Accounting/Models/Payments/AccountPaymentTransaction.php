<?php

namespace App\Accounting\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;

class AccountPaymentTransaction extends Model
{
    use SoftDeletes, UuidTrait,Accountable;

    protected $table = "account_payment_transactions";

    protected $fillable = [
        'payment_type_id',
        'payment_date',
        'amount',
        'status',
    ];

    public function owner(){ return $this->morphTo();} //Enterprise
    public function owning(){ return $this->morphTo();} //Branch
    public function transactionable(){ return $this->morphTo();} //Payment for: Purchases, Salary, Expenses etc

}

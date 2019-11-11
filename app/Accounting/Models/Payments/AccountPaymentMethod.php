<?php

namespace App\Accounting\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ByTestGear\Accountable\Traits\Accountable;
use App\Traits\UuidTrait;

class AccountPaymentMethod extends Model
{
    use SoftDeletes, Accountable, UuidTrait;

    protected $table = "account_payment_methods";

    protected $fillable = [
        'name',
        'description'
    ];

    public function owner(){ return $this->morphTo();}
}

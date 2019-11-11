<?php

namespace App\Models\Practice\Inventory;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeAccountHolder extends Model
{
    use SoftDeletes, Accountable, UuidTrait;
    protected $table = "practice_account_holders";

    protected $fillable = [
        'owner_id', //this may be manufacture, supplier, doctor, Patient, etc
        'owner_type', //this may be manufacture, supplier, doctor, Patient, etc
        'national_id',
        'email',
        'title',
        'address',
        'mobile',
        'country',
        'town',
        'company_name',
        'logo',
        'description',
        'status',
    ];

    public function owner(){
        return $this->morphTo();
    }

}

<?php

namespace App\Models\Product\Expense;

use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes, UuidTrait, Accountable;

    protected $table = 'expenses';

    protected $fillable = [
        'name',
        'description',
        'status',
    ];
}

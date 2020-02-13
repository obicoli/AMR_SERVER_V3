<?php

namespace App\Models\Localization;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes,UuidTrait;

    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = 'countries';
    protected $fillable = [
        'name',
        'code',
        'currency',
        'currency_sympol'
    ];

    public function getName(){ return $this->name; }
    public function getCode(){ return $this->code; }
    public function getCurrency(){ return $this->currency; }
    public function getCurrencySymbol(){ return $this->currency_sympol; }

}

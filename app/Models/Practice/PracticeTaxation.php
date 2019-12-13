<?php

namespace App\Models\Practice;

use App\Accounting\Models\COA\AccountChartAccount;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module\Module;
use App\Models\Product\ProductTaxation;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeTaxation extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "practice_taxations";
    protected $fillable = [
        'product_taxation_id',
        'practice_id',
        'ledger_account_id'
    ];

    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }
    public function product_taxations(){ return $this->belongsTo(ProductTaxation::class,'product_taxation_id','id'); }
    public function ledger_accounts(){ return $this->belongsTo(AccountChartAccount::class,'ledger_account_id','id'); }

}

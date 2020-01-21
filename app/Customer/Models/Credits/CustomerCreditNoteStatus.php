<?php

namespace App\Customer\Models\Credits;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCreditNoteStatus extends Model
{
    //
    use SoftDeletes,UuidTrait;
    protected $connection = Module::MYSQL_CUSTOMER_DB_CONN;
    protected $table = "customer_credit_note_statuses";
    protected $fillable = [
        'status',
        'notes',
        'type',
        'credit_note_id'
    ];
    public function responsible(){ return $this->morphTo();}
    public function creditNotes(){ return $this->belongsTo(CustomerCreditNote::class,'credit_note_id','id'); }
}

<?php

namespace App\Models\Practice;

use App\Models\Module\Module;
use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticeTransactionDocument extends Model
{
    //
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = 'practice_transaction_documents';
    protected $fillable = [
        'name',
        'doc_prefix',
        'doc_title',
        'doc_message',
        'doc_mail_subject',
        'doc_summary',
        'doc_notes',
        'practice_id',
        'transaction_document_id',
    ];

    public function getUuid(){ return $this->uuid; }
    public function getDocPrefix(){ return $this->doc_prefix; }
    public function getName(){ return $this->name; }
    public function getDocTitle(){ return $this->doc_title; }
    public function getDocMessage(){ return $this->doc_message; }
    public function getDocMailSubject(){ return $this->doc_mail_subject; }
    public function getDocSummary(){ return $this->doc_summary; }
    public function getDocNotes(){ return $this->doc_notes; }

    public function transactionDocuments(){ return $this->belongsTo(TransactionDocument::class,'transaction_document_id','id'); }
    public function practices(){ return $this->belongsTo(Practice::class,'practice_id','id'); }
}

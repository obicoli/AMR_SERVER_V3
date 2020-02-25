<?php

namespace App\Models\Practice;

use App\Models\Module\Module;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDocument extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_DB_CONN;
    protected $table = 'transaction_documents';
    protected $fillable = [
        'name',
        'doc_prefix',
        'doc_title',
        'doc_message',
        'doc_mail_subject',
        'doc_summary',
        'doc_notes',
    ];

    public function getUuid(){ return $this->uuid; }
    public function getDocPrefix(){ return $this->doc_prefix; }
    public function getDocTitle(){ return $this->doc_title; }
    public function getDocMessage(){ return $this->doc_message; }
    public function getDocMailSubject(){ return $this->doc_mail_subject; }
    public function getDocSummary(){ return $this->doc_summary; }
    public function getDocNotes(){ return $this->doc_notes; }

    public function practiceTransactionDocuments(){ return $this->hasMany(PracticeTransactionDocument::class,'transaction_document_id','id'); }
}

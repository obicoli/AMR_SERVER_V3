<?php

namespace App\Models\Practice;

use App\Traits\AccountableTrait;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Module\Module;

class PracticeFinanceSetting extends Model
{
    use SoftDeletes, Accountable,UuidTrait;
    protected $connection = Module::MYSQL_PRODUCT_DB_CONN;
    protected $table = "practice_finance_settings";
    protected $fillable = [
        'practice_id',

        'so_prefix',
        'so_title',
        'so_summary',
        'so_terms',
        'so_notes',
        'so_mail_subject',
        'so_text_below_phone',
        'so_due_term',
        'so_bank_details',
        'so_show_shipping',

        'po_prefix',
        'po_title',
        'po_summary',
        'po_terms',
        'po_notes',
        'po_mail_subject',
        'po_text_below_phone',
        'po_due_term',
        'po_bank_details',
        'po_show_shipping',

        'bill_prefix',
        'bill_title',
        'bill_summary',
        'bill_terms',
        'bill_notes',
        'bill_mail_subject',
        'bill_text_below_phone',
        'bill_due_term',
        'bill_bank_details',
        'bill_show_shipping',

        'inv_prefix',
        'inv_title',
        'inv_summary',
        'inv_terms',
        'inv_notes',
        'inv_mail_subject',
        'inv_text_below_phone',
        'inv_due_term',
        'inv_bank_details',
        'inv_show_shipping',

        'est_prefix',
        'est_title',
        'est_summary',
        'est_terms',
        'est_notes',
        'est_mail_subject',
        'est_text_below_phone',
        'est_due_term',
        'est_bank_details',
        'est_show_shipping',

        'cn_prefix',
        'cn_title',
        'cn_summary',
        'cn_terms',
        'cn_notes',
        'cn_mail_subject',
        'cn_text_below_phone',
        'cn_due_term',
        'cn_bank_details',
        'cn_show_shipping',

        'dn_prefix',
        'dn_title',
        'dn_summary',
        'dn_terms',
        'dn_notes',
        'dn_mail_subject',
        'dn_text_below_phone',
        'dn_due_term',
        'dn_bank_details',
        'dn_show_shipping',

        'return_prefix',
        'return_title',
        'return_summary',
        'return_terms',
        'return_notes',
        'return_mail_subject',
        'return_text_below_phone',
        'return_due_term',
        'return_bank_details',
        'return_show_shipping',

    ];
    public function practices(){ return $this->belongsTo(Practice::class,'practice_id'); }
}

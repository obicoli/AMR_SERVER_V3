<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeFinanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_finance_settings');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_finance_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id');
            $table->string('uuid');
            $table->string('so_prefix')->default('SO-');
            $table->string('so_title')->default('Sales Order');
            $table->text('so_summary')->nullable();
            $table->text('so_terms')->nullable();
            $table->text('so_notes')->nullable();
            $table->string('so_mail_subject')->default('Sales Order');
            $table->string('so_text_below_phone')->nullable();
            $table->string('so_due_term')->nullable();
            $table->string('so_bank_details')->nullable();
            $table->boolean('so_show_shipping')->default(true);
            $table->string('po_prefix')->default('PO-');
            $table->string('po_title')->default('Purchase Order');
            $table->text('po_summary')->nullable();
            $table->text('po_terms')->nullable();
            $table->text('po_notes')->nullable();
            $table->string('po_mail_subject')->default('Purchase Order');
            $table->string('po_text_below_phone')->nullable();
            $table->string('po_due_term')->nullable();
            $table->string('po_bank_details')->nullable();
            $table->boolean('po_show_shipping')->default(true);
            $table->string('bill_prefix')->default('BL-');
            $table->string('bill_title')->default('Bill');
            $table->text('bill_summary')->nullable();
            $table->text('bill_terms')->nullable();
            $table->text('bill_notes')->nullable();
            $table->string('bill_mail_subject')->default('Bill');
            $table->string('bill_text_below_phone')->nullable();
            $table->string('bill_due_term')->nullable();
            $table->string('bill_bank_details')->nullable();
            $table->boolean('bill_show_shipping')->default(true);
            $table->string('inv_prefix')->default('INV-');
            $table->string('inv_title')->default('Invoice');
            $table->text('inv_summary')->nullable();
            $table->text('inv_terms')->nullable();
            $table->text('inv_notes')->nullable();
            $table->string('inv_mail_subject')->default('Invoice');
            $table->string('inv_text_below_phone')->nullable();
            $table->string('inv_due_term')->nullable();
            $table->string('inv_bank_details')->nullable();
            $table->boolean('inv_show_shipping')->default(true);
            $table->string('est_prefix')->default('EST-');
            $table->string('est_title')->default('Estimate');
            $table->text('est_summary')->nullable();
            $table->text('est_terms')->nullable();
            $table->text('est_notes')->nullable();
            $table->string('est_mail_subject')->default('Estimate');
            $table->string('est_text_below_phone')->nullable();
            $table->string('est_due_term')->nullable();
            $table->string('est_bank_details')->nullable();
            $table->boolean('est_show_shipping')->default(true);
            $table->string('cn_prefix')->default('CN-');
            $table->string('cn_title')->default('Credit Note');
            $table->text('cn_summary')->nullable();
            $table->text('cn_terms')->nullable();
            $table->text('cn_notes')->nullable();
            $table->string('cn_mail_subject')->default('Credit Note');
            $table->string('cn_text_below_phone')->nullable();
            $table->string('cn_due_term')->nullable();
            $table->string('cn_bank_details')->nullable();
            $table->boolean('cn_show_shipping')->default(true);
            $table->string('dn_prefix')->default('DN-');
            $table->string('dn_title')->default('Debit Note');
            $table->text('dn_summary')->nullable();
            $table->text('dn_terms')->nullable();
            $table->text('dn_notes')->nullable();
            $table->string('dn_mail_subject')->default('Debit Note');
            $table->string('dn_text_below_phone')->nullable();
            $table->string('dn_due_term')->nullable();
            $table->string('dn_bank_details')->nullable();
            $table->boolean('dn_show_shipping')->default(true);
            $table->string('return_prefix')->default('RE-');
            $table->string('return_title')->default('Return-Note');
            $table->text('return_summary')->nullable();
            $table->text('return_terms')->nullable();
            $table->text('return_notes')->nullable();
            $table->string('return_mail_subject')->default('Return Note');
            $table->string('return_text_below_phone')->nullable();
            $table->string('return_due_term')->nullable();
            $table->string('return_bank_details')->nullable();
            $table->boolean('return_show_shipping')->default(true);
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_finance_settings');
    }
}

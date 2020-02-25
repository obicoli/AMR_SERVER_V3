<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeTransactionDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_transaction_documents');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_transaction_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('doc_prefix')->nullable();
            $table->string('doc_title')->nullable();
            $table->string('doc_mail_subject')->nullable();
            $table->text('doc_summary')->nullable();
            $table->text('doc_notes')->nullable();
            $table->text('doc_message')->nullable();
            $table->unsignedInteger('practice_id');
            $table->unsignedInteger('transaction_document_id');
            $table->string('uuid');
            $table->softDeletes();
            Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_transaction_documents');
    }
}

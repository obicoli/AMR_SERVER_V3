<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreateTransactionDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('transaction_documents');
        Schema::connection(Module::MYSQL_DB_CONN)->create('transaction_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('doc_prefix');
            $table->string('doc_title');
            $table->string('doc_mail_subject');
            $table->text('doc_summary')->nullable();
            $table->text('doc_notes')->nullable();
            $table->text('doc_message')->nullable();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('transaction_documents');
    }
}

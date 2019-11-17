<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransactionAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transaction_allocations');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('bank_transaction_allocations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_transaction_id')->index();
            $table->string('uuid');
            $table->unsignedInteger('locatable_id')->index();//Polymorphy Relationship: Links transactions to Invoices,Bills,Payments etc
            $table->string('locatable_type')->index();//Polymorphy Relationship: Links transactions to Invoices,Bills,Payments etc
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transaction_allocations');
    }
}

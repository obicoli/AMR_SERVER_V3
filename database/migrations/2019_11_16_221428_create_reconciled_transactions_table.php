<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReconciledTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('reconciled_transactions');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('reconciled_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_reconciliation_id')->index();
            $table->unsignedInteger('bank_transaction_id')->index();
            $table->unsignedInteger('bank_account_id')->index();
            $table->string('notes')->nullable();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('reconciled_transactions');
    }
}

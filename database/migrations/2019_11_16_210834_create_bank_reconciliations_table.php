<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_reconciliations');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('bank_reconciliations', function (Blueprint $table) {
            $table->increments('id');

            $table->float('account_balance',16,2)->default(00.00)->index();
            $table->float('statement_balance',16,2)->default(00.00)->index(); //reconciled_amount
            $table->float('reconciled_amount',16,2)->default(00.00)->index(); //reconciled_previous
            $table->float('difference',16,2)->default(00.00)->index(); //
            $table->float('reconciled_total',16,2)->default(00.00)->index(); //reconciled_amount
            $table->float('reconciled_previous',16,2)->default(00.00)->index(); //

            // 'reconciled_amount' => 99000,
            // 'reconciled_previous' => 0,
            // 'reconciled_total' => 30099000,
            // 'difference' => -30099000,

            // 'balance' => 30129000,
            // 'statement_balance' => 0,
            // 'statement_date' => NULL,
          
            // 'start_date' => '2019-11-01',
            // 'end_date' => '2019-11-30',

            $table->string('notes')->nullable();
            $table->unsignedInteger('bank_account_id')->index();

            $table->timestamp('start_date')->default(DB::raw("CURRENT_TIMESTAMP"))->index();
            $table->timestamp('end_date')->nullable()->index();
            $table->timestamp('statement_date')->nullable()->index();

            $table->enum('status',['Not Ticked','Ticked','Reconciled'])->default('Not Ticked');
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_reconciliations');
    }
}

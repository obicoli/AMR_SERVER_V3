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
            $table->float('statement_balance',16,2)->default(00.00)->index();
            $table->string('notes')->nullable();
            $table->unsignedInteger('bank_account_id')->index();
            $table->timestamp('start_date')->default(DB::raw("CURRENT_TIMESTAMP"))->index();
            $table->timestamp('end_date')->index()->nullable();
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

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateReconciledTransactionStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('reconciled_transaction_states');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('reconciled_transaction_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->unsignedInteger('reconciled_transaction_id')->index();
            $table->unsignedInteger('responsible_id')->index();
            $table->string('responsible_type')->index();
            $table->string('status')->default('Not Ticked')->index();
            $table->string('notes')->nullable();
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('reconciled_transaction_states');
    }
}

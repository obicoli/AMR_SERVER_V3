<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAccountsOpeningBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_opening_balances');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_opening_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount',16,2)->default(0);
            $table->string('status')->nullable();
            $table->string('reason')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('accountable_id')->index()->nullable(); //E.g Customer,Supplier,Product Item
            $table->string('accountable_type')->index()->nullable(); //E.g Customer,Supplier,Product Item
            $table->unsignedInteger('owning_id')->index(); //Company
            $table->string('owning_type')->index(); //Company
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_opening_balances');
    }
}

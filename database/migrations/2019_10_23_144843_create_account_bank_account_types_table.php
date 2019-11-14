<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;

class CreateAccountBankAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('account_bank_account_types');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('account_bank_account_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('account_bank_account_types');
    }
}

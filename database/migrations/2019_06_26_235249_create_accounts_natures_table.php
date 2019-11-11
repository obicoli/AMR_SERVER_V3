<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsNaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_natures');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_natures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            //$table->boolean('status')->default(true);
            //$table->string('uuid');
            //Accountable::columns($table);
            //$table->softDeletes();
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_natures');
    }
}

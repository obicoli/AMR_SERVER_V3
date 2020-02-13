<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;

class CreatePracticeCustomerZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_customer_zones');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_customer_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->boolean('accounting_zone')->default(false);
            $table->boolean('invoice_and_quotes')->default(false);
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_customer_zones');
    }
}

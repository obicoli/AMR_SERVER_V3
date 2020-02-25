<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_general_settings');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_general_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('ageing_monthly')->default(true);
            $table->enum('ageing_based_on',['Invoice Date','Due Date'])->default('Invoice Date');
            $table->enum('rounding_type',['Round Up','No Rounding','Normal Rounding','Round Down'])->default('Normal Rounding');
            $table->integer('round_to_nearest')->default(10);
            $table->integer('qty_decimal_places')->default(2);
            $table->integer('value_decimal_places')->default(2);
            $table->string('currency_symbol')->default('KES');
            $table->string('system_date_format')->default('d/m/Y');
            $table->unsignedInteger('practice_id')->index();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_general_settings');
    }
}

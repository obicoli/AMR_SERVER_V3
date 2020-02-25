<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeFinancialSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_financial_settings');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_financial_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('financial_year_start')->nullable();
            $table->timestamp('financial_year_end')->nullable();
            $table->boolean('current_accounting_period')->default(false);
            $table->unsignedInteger('practice_id');
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_financial_settings');
    }
}

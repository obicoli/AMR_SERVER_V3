<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrsCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_countries');
        Schema::connection(Module::MYSQL_HR_DB_CONN)->create('hrs_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_sympol')->nullable();
            //$table->unsignedInteger('country_id')->nullable()->index();
            $table->unsignedInteger('region_id')->nullable()->index();
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
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_countries');
    }
}

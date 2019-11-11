<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('countries');
        Schema::connection(Module::MYSQL_DB_CONN)->create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index()->nullable();
            $table->string('name')->index()->nullable();
            $table->string('uuid');
            $table->string('currency')->index()->nullable();
            $table->string('currency_sympol')->index()->nullable();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('countries');
    }
}

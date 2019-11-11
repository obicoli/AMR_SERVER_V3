<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateHrsDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_departments');
        Schema::connection(Module::MYSQL_HR_DB_CONN)->create('hrs_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('manager_id')->index()->nullable();
            $table->unsignedInteger('location_id')->nullable()->index();
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
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_departments');
    }
}

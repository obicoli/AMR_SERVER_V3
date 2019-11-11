<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrsManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_managers');
        Schema::connection(Module::MYSQL_HR_DB_CONN)->create('hrs_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manager_id')->index()->nullable(); //this FK referencing Employees
            $table->unsignedInteger('department_id')->index()->nullable();
            $table->string('status')->nullable();
            $table->float('bonus',16,2)->default(00.00);
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_managers');
    }
}

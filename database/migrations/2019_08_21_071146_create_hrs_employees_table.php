<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateHrsEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_employees');
        Schema::connection(Module::MYSQL_HR_DB_CONN)->create('hrs_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',30)->nullable()->index();
            $table->string('last_name',30)->nullable()->index();
            $table->string('other_name',30)->nullable()->index();
            $table->string('email',30)->nullable()->index();
            $table->string('phone',30)->nullable()->index();
            $table->timestamp('hired_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->float('commission_pct',16,2)->default(00.00);
            $table->unsignedInteger('job_id')->index()->nullable();
            $table->unsignedInteger('department_id')->index()->nullable();
            $table->unsignedInteger('supervisor_id')->index()->nullable();//this FK referencing HrsManager
            $table->unsignedInteger('owner_id')->nullable()->index(); //Enterprise,Organization level
            $table->string('owner_type')->nullable()->index(); //Enterprise,Organization level
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
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
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_employees');
    }
}

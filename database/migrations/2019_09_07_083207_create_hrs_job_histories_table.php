<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateHrsJobHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_job_histories');
        Schema::connection(Module::MYSQL_HR_DB_CONN)->create('hrs_job_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('start_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp('end_date')->nullable();
            $table->unsignedInteger('employee_id')->index()->nullable();
            $table->unsignedInteger('job_id')->index()->nullable();
            $table->unsignedInteger('department_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_HR_DB_CONN)->dropIfExists('hrs_job_histories');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->index()->nullable();
            $table->string('other_name')->index()->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('notes')->nullable();
            $table->string('phone')->index()->nullable();
            $table->string('mobile')->nullable()->index();
            $table->string('email')->index()->nullable();
            $table->float('bill_rate')->default(00.00);
            $table->boolean('billable')->default(false);
            $table->string('national_id')->index()->nullable();
            $table->string('employee_id')->index()->nullable();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('hired_date')->nullable();
            $table->date('released_date')->nullable();
            $table->string('uuid')->index()->unique();
            $table->unsignedInteger('practice_id');
            $table->unsignedInteger('practice_role_id')->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('employees');
    }
}

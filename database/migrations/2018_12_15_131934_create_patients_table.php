<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name')->nullable()->index();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('other_name')->nullable()->index();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->date('date_of_birth')->nullable()->index();
            $table->string('uuid')->nullable()->index();
            $table->string('postcode')->nullable();
            $table->string('time_zone')->nullable();
//            $table->integer('country_id')->unsigned()->default(1);
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('patient_number')->nullable()->index();
            $table->float("longitude")->default(1)->index();
            $table->float("latitude")->default(38)->index();
            $table->text('address')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('patients');
    }
}

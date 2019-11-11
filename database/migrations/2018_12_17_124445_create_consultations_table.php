<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->enum('who_is_patient',['self','dependant'])->default('self')->index();
            $table->enum('doctor_preference',['any','specified'])->default('any')->index();
            $table->enum('visit_type',['physical','online'])->default('online')->index();
            $table->string('status',10)->default('waiting')->index(); //waiting, done, engaged, done, cancelled

//            $table->string('time_bound',10)->nullable();
//            $table->integer('consult_duration')->default(30);
//            $table->string('time_zone')->default('Africa/Nairobi');
//            $table->string('doctor_preference',15)->nullable()->index();

//            $table->integer('patient_id')->unsigned()->default(0);
//            $table->integer('doctor_id')->unsigned()->default(0);
//            $table->integer('domain_id')->unsigned()->nullable();
//            $table->integer('specialist')->unsigned()->nullable();
//            $table->integer('practice_id')->unsigned()->nullable();
//            $table->string('status',10)->default('Pending')->index(); //patient creates consult(Pending), Pays consult(Confirmed), Doctor accepts(Approved), After consultation room(Completed)
//            $table->integer('service_id')->unsigned()->index()->nullable();
//            $table->string('doctor_preference',15)->nullable()->index();
//            $table->enum('who_is_sick',['Self','Dependant'])->default('Self');
//            $table->enum('who_is_sick',['Self','Dependant'])->default('Self');
//            $table->string('time_bound',15)->nullable();
//            $table->string('consult_duration')->default(30); //time in minutes
//            $table->string('time_zone')->default('Africa/Nairobi');
//            $table->string('visit_purpose')->nullable();
//            $table->string('when_started_feeling')->nullable();
//            $table->string('taking_any_medications')->nullable();
//            $table->string('any_allergies')->nullable();
//            $table->string('doctor_signature')->nullable();
//            $table->timestamp('consult_date_time')->nullable();
//            $table->boolean('refund_patient')->default(true);
            $table->string('uuid')->nullable();
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
        Schema::dropIfExists('consultations');
    }
}

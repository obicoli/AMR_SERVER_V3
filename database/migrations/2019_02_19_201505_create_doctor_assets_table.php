<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable()->index();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable()->index();
            $table->integer('owner_id')->unsigned(); //Polymorphic relations: which allow a model(Payment) to belong to more than one other model(Consultation, Appointment, User etc) on a single association(service_id).
            $table->string('owner_type')->index(); //Consultation, Appointments, User
//            $table->unsignedInteger('doctor_id');
//            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
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
        Schema::dropIfExists('doctor_assets');
    }
}

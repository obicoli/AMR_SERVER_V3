<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('dosage');
            $table->boolean('doctor_signed')->default(false);
            $table->string('administration_duration');
            $table->string('patient_direction');
            $table->string('uuid')->nullable();
            $table->unsignedInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
            $table->unsignedInteger('form_id');
            $table->foreign('form_id')->references('id')->on('prescription_forms')->onDelete('cascade');
            $table->unsignedInteger('frequency_id');
            $table->foreign('frequency_id')->references('id')->on('prescription_frequencies')->onDelete('cascade');
            $table->unsignedInteger('route_id');
            $table->foreign('route_id')->references('id')->on('prescription_routes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_prescriptions');
    }
}

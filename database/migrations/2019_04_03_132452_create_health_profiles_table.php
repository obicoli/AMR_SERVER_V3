<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->float('current_height_ft')->default(00.00);
            $table->float('current_height_inch')->default(00.00);
            $table->float('current_weight')->default(00.00);
            $table->boolean('any_health_condition')->default(false);
            $table->boolean('any_medication')->default(false);
            $table->boolean('any_surgeries_procedures')->default(false);
            $table->boolean('any_allergies')->default(false);
            $table->string('uuid');
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
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
        Schema::dropIfExists('health_profiles');
    }
}

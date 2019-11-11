<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->float('cost_per_unit')->default(00.00);
            $table->float('discount')->default(00.00);
            $table->float('units')->default(00.00);
            $table->string('notes')->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid');
            $table->softDeletes();
            $table->unsignedInteger('consultation_id');
            $table->unsignedInteger('proceedure_id');
            $table->foreign('proceedure_id')->references('id')->on('proceedures')->onDelete('cascade');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
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
        Schema::dropIfExists('treatment_plans');
    }
}

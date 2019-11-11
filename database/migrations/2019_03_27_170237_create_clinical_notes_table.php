<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicalNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consultation_id');
            $table->unsignedInteger('complaint_id');
            $table->unsignedInteger('observation_id');
            $table->unsignedInteger('diagnose_id');
            $table->text('notes')->nullable();
            $table->string('uuid');
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('clinical_notes');
    }
}

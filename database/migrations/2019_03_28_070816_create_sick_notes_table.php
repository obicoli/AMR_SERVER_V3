<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSickNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sick_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('doctor_signed')->default(false);
            $table->string('illness_explanation');
            $table->string('uuid')->nullable();
            $table->date('can_resume_when');
            $table->unsignedInteger('excusing_activity_id');
            $table->foreign('excusing_activity_id')->references('id')->on('excuse_activities')->onDelete('cascade');
            $table->unsignedInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
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
        Schema::dropIfExists('sick_notes');
    }
}

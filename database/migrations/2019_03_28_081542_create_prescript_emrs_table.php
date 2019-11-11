<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptEmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescript_emrs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prescription_id');
            $table->unsignedInteger('drug_id');
            $table->unsignedInteger('form_id');
            $table->unsignedInteger('route_id');
            $table->unsignedInteger('frequency_id');
            $table->string('instruction');
            $table->enum('intake',['After food','Before food'])->nullable();
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('form_id')->references('id')->on('prescription_forms')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('prescription_routes')->onDelete('cascade');
            $table->foreign('frequency_id')->references('id')->on('prescription_frequencies')->onDelete('cascade');
            $table->foreign('drug_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::dropIfExists('prescript_emrs');
    }
}

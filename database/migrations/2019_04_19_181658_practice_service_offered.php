<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PracticeServiceOffered extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('practice_service_offered');
        Schema::create('practice_service_offered', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('service_offered_id')->index();
            $table->foreign('practice_id')->references('id')->on('practices')->onDelete('cascade');
            $table->foreign('service_offered_id')->references('id')->on('service_offereds')->onDelete('cascade');
            $table->string('uuid');
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
        Schema::dropIfExists('practice_service_offered');
    }
}

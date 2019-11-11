<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_consults', function (Blueprint $table) {
            $table->increments('id');
            $table->string('time_band',10)->nullable();
            $table->string('any_information')->nullable();
            $table->string('date_fallen_sick')->nullable();
            $table->integer('consult_duration')->default(30);
            $table->string('time_zone')->default('Africa/Nairobi');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid');
            $table->softDeletes();
            $table->unsignedInteger('consultation_id');
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
        Schema::dropIfExists('online_consults');
    }
}

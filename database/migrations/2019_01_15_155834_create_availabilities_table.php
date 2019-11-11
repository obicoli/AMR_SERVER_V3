<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned();
            //$table->integer('practice_id')->unsigned()->nullable();
            $table->enum('week_day',['Mon','Tue','Wen','Thu','Fri','Sat','Sun'])->default('Mon');
            $table->time('opening_time')->default(date('H:i:s',strtotime('07:00:00')));
            $table->time('closing_time')->default(date('H:i:s',strtotime('00:00:00')));
            $table->string('uuid')->nullable();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->timestamps();
        });
    }

//'',
//'week_day',
//'opening_time',
//'closing_time',

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availabilities');
    }
}

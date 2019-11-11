<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDosagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosages', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description');
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::dropIfExists('dosages');
    }
}

//Take this medicine in the dose and duration as advised by your doctor. Swallow it as a whole. Do not chew, crush or break it. MYDAWA Amoxicillin 250mg Capsule may be taken with or without food, but it is better to take it at a fixed time.

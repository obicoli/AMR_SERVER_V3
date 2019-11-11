<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('weight',10);
            $table->string('blood_pressure',10);
            $table->string('resp_rate',10);
            $table->string('temperature',10);
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->unsignedInteger('consultation_id');
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
        Schema::dropIfExists('vital_signs');
    }
}

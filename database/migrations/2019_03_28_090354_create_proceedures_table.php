<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceeduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceedures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('cost_per_unit')->default(00.00);
            $table->float('discount')->default(00.00);
            $table->float('units')->default(00.00);
            $table->string('uuid');
            $table->softDeletes();
            $table->unsignedInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
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
        Schema::dropIfExists('proceedures');
    }
}

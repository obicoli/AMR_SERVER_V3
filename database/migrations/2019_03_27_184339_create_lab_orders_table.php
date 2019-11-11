<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consultation_id');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->text('instruction')->nullable();
            $table->string('uuid');
            $table->softDeletes();
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
        Schema::dropIfExists('lab_orders');
    }
}

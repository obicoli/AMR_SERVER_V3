<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->float('cost')->default(00.00);
            $table->string('owner_type');
            $table->string('service_type')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedInteger('owner_id');
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
        Schema::dropIfExists('service_charges');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->increments('id');
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid');
            $table->string('region')->nullable();
            $table->string('area')->nullable();
            $table->string('street')->nullable();
            $table->string('estate_landmark_buildings')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->softDeletes();
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
        Schema::dropIfExists('delivery_addresses');
    }
}

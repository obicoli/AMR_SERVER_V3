<?php

use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note')->nullable();
            $table->string('status')->nullable();
            $table->string('trans_number')->nullable();
            $table->unsignedInteger('vehicle_id')->index()->nullable();
            $table->unsignedInteger('driver_id')->index()->nullable();
            $table->unsignedInteger('account_id')->index()->nullable();
            $table->unsignedInteger('payment_type_id')->index()->nullable();

            $table->unsignedInteger('owner_id')->nullable(); //Enterprise
            $table->string('owner_type')->nullable();//Enterprise

            $table->unsignedInteger('src_owning_id')->nullable()->index();
            $table->string('src_owning_type')->nullable()->index();
            
            $table->unsignedInteger('src_store_id')->nullable()->index();
            $table->unsignedInteger('src_department_id')->nullable()->index();
            $table->unsignedInteger('src_sub_store_id')->nullable()->index();

            $table->unsignedInteger('dest_owning_id')->nullable()->index();
            $table->string('dest_owning_type')->nullable()->index();

            $table->unsignedInteger('dest_store_id')->nullable()->index();
            $table->unsignedInteger('dest_department_id')->nullable()->index();
            $table->unsignedInteger('dest_sub_store_id')->nullable()->index();

            $table->string('uuid')->index();
            $table->softDeletes();
            Accountable::columns($table);
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
        Schema::dropIfExists('product_supplies');
    }
}

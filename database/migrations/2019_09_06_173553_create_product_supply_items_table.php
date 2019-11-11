<?php

use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSupplyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_supply_items', function (Blueprint $table) {
            $table->increments('id');
            $table->float('qty')->default(0);
            $table->float('discount_allowed',8,2)->default(00.00);
            $table->float('total_tax',8,2)->default(00.00);
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('product_supply_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('product_item_id')->index();
            $table->string('uuid');
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
        Schema::dropIfExists('product_supply_items');
    }
}

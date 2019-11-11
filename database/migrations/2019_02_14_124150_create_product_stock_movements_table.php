<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('movement_direction')->default('add'); //add, consume, expired, shrinkage
            $table->float('amount');
            $table->float('unit_cost');
            $table->float('total_cost');
            $table->string('batch_number');
            $table->unsignedInteger('product_stock_id')->index()->nullable();
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('product_stock_movements');
    }
}

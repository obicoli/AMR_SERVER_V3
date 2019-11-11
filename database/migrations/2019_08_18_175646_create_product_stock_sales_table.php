<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStockSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->float('amount')->index();
            // $table->float('unit_cost')->index();
            // $table->float('total_cost')->index();
            //$table->string('batch_number')->index();
            $table->unsignedInteger('product_stock_id')->index()->nullable();
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->unsignedInteger('product_price_id')->index()->nullable();
            // $table->string('owner_type')->index();
            // $table->unsignedInteger('owner_id')->index();
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
        Schema::dropIfExists('product_stock_sales');
    }
}

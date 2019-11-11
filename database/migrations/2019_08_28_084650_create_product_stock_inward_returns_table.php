<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStockInwardReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_inward_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_stock_inward_id')->index()->nullable();
            $table->float('amount')->default(0.00)->index();
            $table->string('sourceable_type')->index()->nullable(); //Customer Return
            $table->unsignedInteger('sourceable_id')->index()->nullable();//Customer Return
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
        Schema::dropIfExists('product_stock_inward_returns');
    }
}

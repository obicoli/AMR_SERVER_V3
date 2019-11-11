<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('product_sale_id')->index();
            $table->unsignedInteger('practice_product_item_id')->index();
            $table->string('item_weight')->index()->nullable();
            $table->integer('qty')->default(0); //quantity sold
            $table->float('price_per_item')->default(00.00);
            $table->float('gross_total')->default(00.00); //this is: $qty_sold*$price_per_item
            $table->float('tax_total')->default(00.00);
            $table->float('other_sale_charge_total')->default(00.00);
            $table->float('disc_allowed')->default(00.00); //discount allowed
            $table->float('net_total')->default(00.00); //final sales price: $qty_sold*$price_per_item - ($tax_total + $other_sale_charge_total)
            $table->string('batch_number')->index()->nullable();
            $table->string('status')->default('pending'); //pending, approved, removed
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
        Schema::dropIfExists('product_sale_items');
    }
}

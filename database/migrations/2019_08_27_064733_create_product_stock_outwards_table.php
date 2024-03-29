<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductStockOutwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_outwards', function (Blueprint $table) {
            $table->increments('id');//
            $table->unsignedInteger('product_item_id')->index()->nullable();//
            $table->unsignedInteger('product_stock_id')->index()->nullable();//
            $table->unsignedInteger('product_item_price_id')->index()->nullable();//
            $table->float('amount')->default(0.00)->index();//
            $table->string('batch_number')->index()->nullable();//
            $table->string('outward_type')->index()->nullable(); //
            $table->string('barcode')->index()->nullable();

            // $table->string('sourceable_type')->index()->nullable(); //Source of stock: PO, Requistions, Purchases
            // $table->unsignedInteger('sourceable_id')->index()->nullable(); //Source of stock: PO, Requistions, Purchases
            // $table->boolean('is_depleted')->default(false)->index();//
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owner_type')->index()->nullable();
            $table->string('owning_type')->index()->nullable(); //Branch
            $table->unsignedInteger('owning_id')->index()->nullable(); //Branch
            $table->unsignedInteger('department_id')->index()->nullable();//
            $table->unsignedInteger('store_id')->index()->nullable();//
            $table->unsignedInteger('sub_store_id')->index()->nullable();//
            
            $table->softDeletes();//
            $table->string('uuid')->index();//
            Accountable::columns($table);//
            $table->timestamps();//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock_outwards');
    }
}

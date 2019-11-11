<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductRequistionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requistion_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->unsignedInteger('product_requistion_id')->index()->nullable();
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->unsignedInteger('product_price_id')->index()->nullable();
            $table->float('amount',16,2)->default(00.00);
            $table->float('amount_approved',16,2)->default(00.00);
            $table->float('amount_shpped',16,2)->default(00.00);
            $table->float('amount_received',16,2)->default(00.00);
            Accountable::columns($table);
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
        Schema::dropIfExists('product_requistion_items');
    }
}

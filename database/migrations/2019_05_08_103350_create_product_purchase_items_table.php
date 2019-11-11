<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_items', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('practice_id')->index();
            $table->integer('qty')->default(0);
            $table->unsignedInteger('product_purchase_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('practice_product_item_id')->index();
            $table->string('batch_number')->index()->nullable();
            $table->integer('man_month')->index()->nullable(); //month of manufacture
            $table->integer('man_year')->index()->nullable(); //year of manufacture
            $table->integer('exp_month')->index()->nullable();
            $table->integer('exp_year')->index()->nullable();
            $table->string('status')->default('pending'); //pending, approved, added
            $table->string('uuid');
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('product_purchase_items');
    }
}

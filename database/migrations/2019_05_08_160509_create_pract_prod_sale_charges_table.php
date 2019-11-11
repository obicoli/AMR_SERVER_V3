<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractProdSaleChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this table connects a m:m relationship btn practice_product_items & product_sales_charges
        Schema::create('pract_prod_sale_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_product_item_id')->index();
            $table->unsignedInteger('product_sales_charge_id')->index();
            $table->softDeletes();
            $table->string('uuid')->index();
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
        Schema::dropIfExists('pract_prod_sale_charges');
    }
}

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('practice_product_item_id')->index();
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('unit_cost')->default(00.00)->index();
            $table->float('unit_retail_price')->default(00.00)->index();
            $table->float('pack_cost')->default(00.00)->index();
            $table->float('pack_retail_price')->default(00.00)->index();
            $table->string('uuid')->index()->unique();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('product_price_records');
    }
}

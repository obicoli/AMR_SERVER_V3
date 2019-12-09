<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('purchase_order_items');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('purchase_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->float('qty')->default(00.00);
            $table->unsignedInteger('purchase_order_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('product_item_id')->index();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->string('uuid')->nullable();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('purchase_order_items');
    }
}

<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_return_items');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_return_items', function (Blueprint $table) {
            $table->increments('id');
            $table->float('qty')->default(00.00);
            $table->float('discount_rate')->default(00.00);
            $table->float('line_discount')->default(00.00);
            $table->unsignedInteger('supplier_return_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('product_item_id')->index();
            $table->string('uuid')->nullable();
            $table->foreign('supplier_return_id')->references('id')->on('supplier_returns')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_return_items');
    }
}

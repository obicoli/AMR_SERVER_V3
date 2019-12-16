<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_items');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_bill_items', function (Blueprint $table) {
            $table->increments('id');
            $table->float('qty')->default(00.00);
            //$table->string('description')->nullable();
            $table->unsignedInteger('supplier_bill_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('product_item_id')->index();
            $table->string('uuid')->nullable();
            $table->foreign('supplier_bill_id')->references('id')->on('supplier_bills')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_items');
    }
}

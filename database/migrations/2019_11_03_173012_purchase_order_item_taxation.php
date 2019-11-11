<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseOrderItemTaxation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('po_item_taxations');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('po_item_taxations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('po_item_id')->index();
            $table->unsignedInteger('product_taxation_id')->index();
            $table->float('sales_rate',8,2)->default(00.00);
            $table->float('purchase_rate',8,2)->default(00.00);
            $table->boolean('collected_on_sales')->default(false);
            $table->boolean('collected_on_purchase')->default(false);
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('po_item_taxations');
    }
}

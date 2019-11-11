<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductStockInwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stock_inwards');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_stock_inwards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->unsignedInteger('product_price_id')->index()->nullable();
            $table->unsignedInteger('product_stock_id')->index()->nullable();
            $table->float('amount',16,2)->default(0.00)->index();
            $table->float('consumed_amount',16,2)->default(0.00)->index();
            $table->string('barcode')->index()->nullable();
            $table->string('batch_number')->index()->nullable();
            $table->date('mfg_date')->nullable()->index();
            $table->date('exp_date')->nullable()->index();
            //This is source of inward stock
            $table->string('source_type')->index()->default('Purchase'); //e.g Purchase, Customer Return, Requisition
            //if source is Requisition use Requisition to get Source:facility,department,store & substore
            //if source is Customer Return use it to get Source:Patient,Purchase Returns etc
            //if source is Purchase use it to get Source:Supplier or Vendor
            $table->string('sourceable_type')->index()->nullable(); //Source of stock: PO, Requistions, Purchases etc
            $table->unsignedInteger('sourceable_id')->index()->nullable(); //Source of stock: PO, Requistions, Purchases
            //Facility where this is happenning
            $table->string('owner_type')->index()->nullable(); //Enterprise
            $table->unsignedInteger('owner_id')->index()->nullable(); //Enterprise
            $table->string('owning_type')->index()->nullable(); //Branch
            $table->unsignedInteger('owning_id')->index()->nullable(); //Branch
            $table->unsignedInteger('department_id')->index()->nullable(); //Department
            $table->unsignedInteger('store_id')->index()->nullable(); //Store
            $table->unsignedInteger('sub_store_id')->index()->nullable(); //Sub store

            $table->softDeletes();
            $table->string('uuid')->index();
            Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stock_inwards');
    }
}

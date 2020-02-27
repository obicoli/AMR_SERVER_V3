<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stocks');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_item_id')->index();
            $table->unsignedInteger('product_item_price_id')->index();
            $table->float('amount')->default(0.00)->index();
            $table->string('source_type')->index()->nullable();
            $table->string('status')->index()->default('Pending');
//            $table->string('owner_type')->index()->nullable(); //Enterprise
//            $table->unsignedInteger('owner_id')->index()->nullable(); //Enterprise
            $table->string('owning_type')->index()->nullable(); //Branch
            $table->unsignedInteger('owning_id')->index()->nullable(); //Branch
            $table->string('sourceable_type')->index()->nullable(); //Source of stock: PO, Requistions, Purchases, Opening Balance
            $table->unsignedInteger('sourceable_id')->index()->nullable(); //Source of stock: PO, Requistions, Purchases, Opening Balance
            $table->boolean('is_depleted')->default(false)->index();
            $table->unsignedInteger('department_id')->index()->nullable();
            $table->unsignedInteger('store_id')->index()->nullable();
            $table->unsignedInteger('sub_store_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stocks');
    }
}

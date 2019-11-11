<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStockSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stock_out_supplies');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_stock_out_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_stock_inward_id')->index()->nullable();//
            $table->unsignedInteger('product_supply_item_id')->index()->nullable();//
            $table->float('amount')->default(0.00)->index();//
            $table->string('batch_number')->index()->nullable();//
            $table->softDeletes();//
            $table->string('uuid')->index();//
            Accountable::columns($table);//
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stock_out_supplies');
    }
}

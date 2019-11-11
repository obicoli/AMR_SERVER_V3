<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductStockTakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_stock_takings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->float('qty',16,2)->default(00);
            $table->unsignedInteger('product_stock_inward_id')->index()->nullable();
            $table->string('barcode')->index()->nullable();
            $table->string('owner_type')->index()->nullable(); //Enterprise
            $table->unsignedInteger('owner_id')->index()->nullable(); //Enterprise
            $table->string('owning_type')->index()->nullable(); //Branch
            $table->unsignedInteger('owning_id')->index()->nullable(); //Branch
            $table->unsignedInteger('department_id')->index()->nullable(); //Department
            $table->unsignedInteger('store_id')->index()->nullable(); //Store
            $table->unsignedInteger('sub_store_id')->index()->nullable(); //Sub store
            Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stock_takings');
    }
}

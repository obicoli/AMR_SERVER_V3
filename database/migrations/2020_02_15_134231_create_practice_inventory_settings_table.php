<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeInventorySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_inventory_settings');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_inventory_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->boolean('warn_item_qty_zero')->default(true);
            $table->boolean('disallow_qty_zero')->default(true);
            $table->boolean('warn_item_cost_zero')->default(true);
            $table->boolean('warn_item_selling_zero')->default(true);
            $table->boolean('warn_item_sale_below_cost')->default(true);
            $table->boolean('show_inactive_items')->default(true);
            $table->boolean('show_inactive_item_category')->default(true);
            $table->boolean('sales_order_reserve_item')->default(true);
            $table->boolean('batch_tracking')->default(false);
            $table->boolean('barcode_tracking')->default(false);
            $table->boolean('multi_warehouse_management')->default(false);
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_inventory_settings');
    }
}

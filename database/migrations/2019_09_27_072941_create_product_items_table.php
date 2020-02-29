<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_items');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owner_type')->index()->nullable();
            $table->unsignedInteger('product_id')->index()->nullable();
            $table->unsignedInteger('generic_id')->index()->nullable();
            $table->unsignedInteger('manufacturer_id')->index()->nullable();
            $table->unsignedInteger('product_type_id')->index()->nullable();
            $table->unsignedInteger('product_category_id')->index()->nullable();
            $table->unsignedInteger('product_sub_category_id')->index()->nullable();
            $table->unsignedInteger('product_route_id')->index()->nullable()->nullable();
            $table->unsignedInteger('product_brand_id')->index()->nullable();
            $table->unsignedInteger('product_brand_sector_id')->index()->nullable();
            $table->unsignedInteger('product_unit_id')->index()->nullable();
            $table->unsignedInteger('product_order_category_id')->index()->nullable();//-----------
            $table->unsignedInteger('product_formulation_id')->index()->nullable(); //-----------
            $table->unsignedInteger('prefered_supplier_id')->index()->nullable(); //-----------
            $table->unsignedInteger('product_profile_id')->index()->nullable(); //-----------
            $table->unsignedInteger('product_manufacturer_id')->index()->nullable(); //-------------
            $table->boolean('status')->index()->default(true);
            $table->boolean('confirmed')->index()->default(true);
            $table->enum('inventory_tracking',['None','Batch','Barcode','Serial'])->default('None');
            $table->string('item_code')->index();
            $table->string('notes')->nullable();
            $table->string('unit_storage_location')->nullable();
            $table->string('single_unit_weight')->index()->nullable();
            $table->string('alert_indicator_level')->index()->nullable();
            $table->string('units_per_pack')->index()->nullable();
            $table->string('uuid')->index();
            $table->softDeletes();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_items');
    }
}

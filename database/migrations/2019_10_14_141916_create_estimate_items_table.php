<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimate_items');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('estimate_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('estimate_id')->index()->nullable();
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->unsignedInteger('product_price_id')->index()->nullable();
            $table->float('qty',16,2)->default(00.00); //discount_allowed
            $table->float('discount_allowed',8,2)->default(00.00); //Percentage
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimate_items');
    }
}

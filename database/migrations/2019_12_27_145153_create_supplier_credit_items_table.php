<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierCreditItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_credit_items');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_credit_items', function (Blueprint $table) {
            $table->increments('id');
            $table->float('qty',16,2)->default(00.00);
            $table->float('line_discount',16,2)->default(00.00);
            $table->unsignedInteger('supplier_credit_id')->index();
            $table->unsignedInteger('product_price_id')->index();
            $table->unsignedInteger('product_item_id')->index();
            $table->string('uuid')->nullable();
            $table->foreign('supplier_credit_id')->references('id')->on('supplier_credits')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_credit_items');
    }
}

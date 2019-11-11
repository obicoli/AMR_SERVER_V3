<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductItemTaxation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_item_taxations');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_item_taxations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_item_id')->index();
            $table->unsignedInteger('product_taxation_id')->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_item_taxations');
    }
}

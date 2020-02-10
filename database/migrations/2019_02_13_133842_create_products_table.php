<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('products');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->index();
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true)->index();
            $table->unsignedBigInteger('owner_id')->nullable()->index();
            $table->string('owner_type')->nullable()->index();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid')->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('products');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;


class CreateProductStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stores');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedInteger('practice_id')->index();
            $table->boolean('status')->default(true);
            $table->boolean('is_default')->default(true);
            $table->float('min_capacity',16,2)->default(1000000);
            $table->float('max_capacity',16,2)->default(1000000);
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_stores');
    }
}

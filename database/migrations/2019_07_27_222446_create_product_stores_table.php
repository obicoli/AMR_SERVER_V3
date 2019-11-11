<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->boolean('status')->default(true);
            $table->enum('type',['main','sub store'])->default('sub store');
            $table->integer('min_capacity')->default(1000000);
            $table->integer('max_capacity')->default(1000000);
            $table->unsignedInteger('owner_id')->nullable();//This is Enterprice
            $table->string('owner_type')->nullable();//This is Enterprice
            $table->unsignedInteger('store_locatable_id')->nullable()->index(); //facility in Enterprise owning store
            $table->string('store_locatable_type')->nullable()->index(); //facility in Enterprise owning store
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
        Schema::dropIfExists('product_stores');
    }
}

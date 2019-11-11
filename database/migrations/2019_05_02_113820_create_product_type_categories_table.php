<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_type_id')->index();
            $table->unsignedInteger('product_category_id')->index();
            $table->string('uuid')->index()->nullable();
            $table->string('owner_type')->index();
            $table->unsignedInteger('owner_id')->index();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('product_type_categories');
    }
}

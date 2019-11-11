<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PracticeProductType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('practice_product_type');
        Schema::create('practice_product_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('product_type_id')->index();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('practice_product_type');
    }
}

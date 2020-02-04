<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductGenericsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_generics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('uuid')->index()->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true);
            //$table->unsignedInteger('practice_id')->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_generics');
    }
}

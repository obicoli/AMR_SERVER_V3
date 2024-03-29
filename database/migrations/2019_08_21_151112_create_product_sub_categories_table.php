<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_sub_categories');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->index();
            $table->string('description')->nullable();
            $table->string('uuid')->nullable();
            $table->boolean('status')->default(true)->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_sub_categories');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_types');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->boolean('default_sys')->default(false);
            $table->string('description')->nullable();
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owner_type')->index()->nullable();
            $table->boolean('status')->default(true);
            $table->string('uuid')->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_types');
    }
}

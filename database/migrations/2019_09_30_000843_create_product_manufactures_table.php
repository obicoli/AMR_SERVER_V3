<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductManufacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_manufactures');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_manufactures', function (Blueprint $table) {
            $table->increments('id');
            $table->string("uuid")->unique();
            $table->string("name")->nullable();
            $table->string("slug")->nullable();
            $table->unsignedInteger("owner_id")->nullable();
            $table->string("owner_type")->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_manufactures');
    }
}

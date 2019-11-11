<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAdministrationRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_administration_routes');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_administration_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index();
            $table->string('description')->nullable();
            $table->boolean('default_sys')->default(false);
            $table->string('uuid')->index();
            $table->unsignedInteger('owner_id')->nullable();
            $table->string('owner_type')->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_administration_routes');
    }
}

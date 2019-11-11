<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBrandSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_brand_sectors');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_brand_sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('description')->nullable();
            $table->string('uuid')->index();
            $table->boolean('status')->default(true);
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owner_type')->index()->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_brand_sectors');
    }
}

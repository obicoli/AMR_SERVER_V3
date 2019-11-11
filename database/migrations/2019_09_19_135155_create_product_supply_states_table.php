<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSupplyStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_supply_states');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_supply_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->unsignedInteger('product_supply_id')->nullable()->index();
            $table->string('status')->default('Pending')->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_supply_states');
    }
}

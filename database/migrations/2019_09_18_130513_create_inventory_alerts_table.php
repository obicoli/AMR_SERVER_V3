<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('inventory_alerts');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('inventory_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('products')->default('all');
            $table->string('stores')->default('all');
            $table->boolean('email_enabled')->default(false);
            $table->boolean('sms_enabled')->default(false);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('message')->nullable();
            $table->unsignedInteger('frequency_id')->index()->nullable();
            $table->string('uuid');
            $table->string('owner_type')->index()->nullable();
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owning_type')->index()->nullable();
            $table->unsignedInteger('owning_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('inventory_alerts');
    }
}

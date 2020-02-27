<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;

class CreateManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->dropIfExists('manufacturers');
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->create('manufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable();
            $table->string("uuid")->unique();
            $table->unsignedInteger("owner_id")->nullable()->index();
            $table->string('owner_type')->nullable()->index();
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
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->dropIfExists('manufacturers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;

class CreateManufacturerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->dropIfExists('manufacturer_profiles');
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->create('manufacturer_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string("uuid")->unique();
            $table->float("longitude")->default(1);
            $table->float("latitude")->default(38);
            $table->string("support_email")->nullable();
            $table->string("sales_email")->nullable();
            $table->string("contact_email")->nullable();
            $table->string("phone")->nullable();
            $table->string("status")->default("pending");
            $table->unsignedInteger("manufacturer_id")->index();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("website")->nullable();
            $table->string("facebook")->nullable();
            $table->string("twitter")->nullable();
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
        Schema::connection(Module::MYSQL_MANUFACTURER_DB_CONN)->dropIfExists('manufacturer_profiles');
    }
}

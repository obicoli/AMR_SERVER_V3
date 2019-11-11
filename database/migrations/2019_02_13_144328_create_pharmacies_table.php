<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->increments('id');
            $table->string("slug")->nullable();
            $table->string("uuid")->unique()->index();
            $table->string("name")->nullable()->index();
            $table->string("description")->nullable();
            $table->string("logo")->nullable();
            $table->float("longitude")->default(1)->index();
            $table->float("latitude")->default(38)->index();
            $table->string("contact_email")->nullable()->index();
            $table->string("phone")->nullable()->index();
            $table->string("approval_status")->default("pending")->index();
            //$table->unsignedInteger("owner_id")->nullable();
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("country")->nullable()->index();
            $table->string("city")->nullable()->index();
            $table->string("website")->nullable()->index();
            $table->string("address")->nullable()->index();
            $table->string("facebook")->nullable();
            $table->string("twitter")->nullable();
            $table->string("registration_number")->nullable()->index();
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
        Schema::dropIfExists('pharmacies');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            //$table->integer('domain_id')->unsigned()->index()->nullable();
            //$table->integer('specialist_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            //$table->string('specialist')->nullable();
            //$table->string('last_name')->nullable();
            $table->string('other_name')->nullable();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->date('date_of_birth')->nullable();
            //$table->string('email')->nullable()->index();
            $table->string('uuid')->nullable()->index();
            //$table->string('mobile')->nullable()->index();
            //$table->string('registration_number')->nullable();
            $table->string('postcode')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('country')->default('Kenya');
            $table->string('city')->default('Nairobi');
            $table->float("longitude")->default(1);
            $table->float("latitude")->default(38);
            $table->string('title')->default('Dr');
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            //$table->boolean('own_practice')->nullable();
            //$table->string('avatar')->nullable();
            $table->boolean('admin_verified')->default(false);
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}

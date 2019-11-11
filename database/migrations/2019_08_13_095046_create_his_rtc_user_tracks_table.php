<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHisRtcUserTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('his_rtc_user_tracks', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('owner_id')->unsigned()->nullable();//Enterprise
            $table->string('owner_type')->nullable()->index();//Enterprise
            $table->integer('owning_id')->unsigned()->nullable();//Facility
            $table->string('owning_type')->nullable()->index(); //Facility
            $table->integer('store_id')->unsigned()->nullable(); //store
            $table->integer('department_id')->unsigned()->nullable();//Department
            $table->integer('sub_store_id')->unsigned()->nullable(); //sub store
            $table->string('service_type')->index()->nullable();//Service/Page where user is
            $table->string('service_action')->index()->nullable();//Service/Action where user is
            $table->string('first_name')->index()->nullable();
            $table->string('last_name')->index()->nullable();
            $table->integer('practice_user_id')->unsigned()->nullable();
            $table->string('resource_id',20)->index();
            // $table->integer('room_id')->nullable()->index();
            // $table->integer('group_id')->nullable()->index();
            // $table->string('avatar')->default('/assets/images/user.png');
            // $table->string('salute')->nullable()->index();
            //$table->string('uuid');
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
        Schema::dropIfExists('his_rtc_user_tracks');
    }
}

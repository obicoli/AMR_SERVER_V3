<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_TELEMEDICINE_DB_CONN)->dropIfExists('online_tracks');
        Schema::connection(Module::MYSQL_TELEMEDICINE_DB_CONN)->create('online_tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('traceable_id')->unsigned()->nullable();
            $table->string('traceable_type')->nullable();
            $table->string('resource_id')->index();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->integer('room_id')->nullable()->index();
            $table->integer('group_id')->nullable()->index();
            $table->string('avatar')->default('/assets/images/user.png');
            $table->string('salute')->nullable()->index();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_TELEMEDICINE_DB_CONN)->dropIfExists('online_tracks');
    }
}

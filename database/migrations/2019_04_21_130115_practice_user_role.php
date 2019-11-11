<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PracticeUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('practice_user_role');
        Schema::create('practice_user_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_user_id')->index();
            $table->unsignedInteger('role_id')->index();
            //$table->foreign('practice_user_id')->references('id')->on('practices_users')->onDelete('cascade');
            //$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('practice_user_role');
    }
}

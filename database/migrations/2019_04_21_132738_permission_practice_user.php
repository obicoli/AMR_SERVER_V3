<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionPracticeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('permission_practice_user');
        Schema::create('permission_practice_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_user_id')->index();
            $table->unsignedInteger('permission_id')->index();
            //$table->foreign('practice_user_id')->references('id')->on('practices_users')->onDelete('cascade');
            //$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
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
        Schema::dropIfExists('permission_practice_user');
    }
}

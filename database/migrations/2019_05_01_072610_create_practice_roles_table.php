<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_roles', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('role_id')->index();
            $table->unsignedInteger('practice_id')->index();
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->string('uuid')->index();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->timestamps();
        });

        Schema::dropIfExists('practice_role_role');
        Schema::create('practice_role_role', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('role_id')->index();
            $table->unsignedInteger('practice_role_id')->index();
            $table->unsignedInteger('role_id')->index();
            $table->timestamps();
        });

        Schema::dropIfExists('permission_practice_role');
        Schema::create('permission_practice_role', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('role_id')->index();
            $table->unsignedInteger('practice_role_id')->index();
            $table->unsignedInteger('permission_id')->index();
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
        Schema::dropIfExists('practice_roles');
    }
}

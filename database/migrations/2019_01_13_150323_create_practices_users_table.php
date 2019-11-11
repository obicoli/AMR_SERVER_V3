<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('practices_users');
        Schema::create('practices_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->index();
            $table->boolean('facility')->default(true);
            $table->string('first_name')->index()->nullable();
            $table->string('other_name')->index()->nullable();
            $table->string('email')->index()->nullable();
            $table->string('mobile')->index()->nullable();
            $table->string('gender')->index()->nullable();
            $table->string('status')->default('Active');
            $table->enum('billable',['Yes','No'])->default('No');
            $table->string('address')->index()->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('sub_store_id')->nullable();
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
        Schema::dropIfExists('practices_users');
    }
}

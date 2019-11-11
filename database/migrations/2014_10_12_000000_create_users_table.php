<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('uuid')->unique();
            $table->enum('status',['Banned','Pending','Deactivated','Activated','Blocked','Registered'])->default('Registered');
            $table->boolean('email_verified')->default(false);
            $table->boolean('mobile_verified')->default(false);
            $table->ipAddress('signup_ip_address')->nullable();
            $table->ipAddress('signup_confirmation_ip_address')->nullable();
            $table->ipAddress('signup_sm_ip_address')->nullable();
            $table->string('password')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('department_id')->nullable();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('sub_store_id')->nullable();
            $table->unsignedInteger('company_user_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('users');
    }
}

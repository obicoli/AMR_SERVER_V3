<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('practice_users_profiles');
        Schema::create('practice_users_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->index()->unique();
            $table->string('first_name')->index();
            $table->string('other_name')->index();
            $table->string('email')->index()->unique();
            $table->string('mobile')->index()->unique();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->unsignedInteger('practice_user_id')->index();
            //$table->foreign('practice_user_id')->references('id')->on('practices_users')->onDelete('cascade');
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
        Schema::dropIfExists('practice_users_profiles');
    }
}

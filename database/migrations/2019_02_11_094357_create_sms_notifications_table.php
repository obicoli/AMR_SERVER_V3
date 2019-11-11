<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recipient_mobile')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('sms_notificationsable_id')->unsigned()->nullable();
            $table->string('sms_notificationsable_type')->nullable()->nullable();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid')->nullable();
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
        Schema::dropIfExists('sms_notifications');
    }
}

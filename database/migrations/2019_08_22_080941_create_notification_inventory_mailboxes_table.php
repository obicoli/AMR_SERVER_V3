<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationInventoryMailboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mail_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('Pending');
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->string('msg')->nullable();
            $table->integer('resend_count')->default(0);
            $table->string('uuid');
            $table->string('owner_type')->index()->nullable();
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owning_type')->index()->nullable();
            $table->unsignedInteger('owning_id')->index()->nullable();
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
        Schema::dropIfExists('product_mail_boxes');
    }
}

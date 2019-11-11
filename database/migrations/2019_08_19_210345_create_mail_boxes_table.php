<?php

use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable()->index();
            $table->string('message')->nullable();
            $table->string('to_')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('resend_count')->default(0);
            $table->string('uuid');
            Accountable::columns($table);
            $table->softDeletes();
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
        Schema::dropIfExists('mail_boxes');
    }
}

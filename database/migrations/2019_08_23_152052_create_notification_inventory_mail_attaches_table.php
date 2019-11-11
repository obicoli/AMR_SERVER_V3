<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationInventoryMailAttachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mail_attaches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_mailbox_id')->index();
            $table->string('uuid');
            $table->string('attachment_type')->index()->nullable();
            $table->string('attachable_type')->index()->nullable();
            $table->unsignedInteger('attachable_id')->index()->nullable();
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
        Schema::dropIfExists('product_mail_attaches');
    }
}

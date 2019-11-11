<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateGrnNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_note_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grn_note_id')->index();
            $table->unsignedInteger('product_item_id')->index()->nullable();
            $table->string('uuid')->index();
            $table->string('comment')->nullable();
            $table->integer('amount')->index();
            $table->unsignedInteger('owner_id')->index()->nullable(); //This can be ProductPOItems: Id
            $table->string('owner_type')->nullable()->index(); //This can be ProductPOItems: Id
            $table->softDeletes();
            Accountable::columns($table);
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
        Schema::dropIfExists('grn_note_items');
    }
}

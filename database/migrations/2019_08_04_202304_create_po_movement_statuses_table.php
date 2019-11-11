<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreatePoMovementStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_movement_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->string('uuid');
            $table->unsignedInteger('po_id')->index();
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
        Schema::dropIfExists('po_movement_statuses');
    }
}

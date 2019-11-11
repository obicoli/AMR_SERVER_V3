<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->softDeletes();
            $table->string('uuid');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('stop_date')->nullable();
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
        Schema::dropIfExists('subscriptions');
    }
}

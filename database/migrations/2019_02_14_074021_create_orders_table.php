<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index(); //can be patient,doctor,suppliers, pharmacy
            $table->string('owner_type')->index();//can be patient,doctor,suppliers, pharmacy
            $table->timestamp('date_order_placed')->default(date('Y-m-d H:i:s'));
            $table->timestamp('date_order_paid')->nullable();
            $table->float('total_order_price')->default(0.0);
            $table->string('other_order_details')->nullable();
            $table->unsignedInteger('delivery_status_id');
            $table->string('uuid');
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
        Schema::dropIfExists('orders');
    }
}

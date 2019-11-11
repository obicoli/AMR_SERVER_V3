<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('description')->index();
            $table->unsignedInteger('payment_type_id')->index();
            $table->float('vendor_fee')->default(00.00);
            $table->unsignedInteger('owner_id')->index();
            $table->string('owner_type')->index();
            $table->boolean('status')->default(true);
            $table->string('uuid');
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('account_payment_methods');
    }
}

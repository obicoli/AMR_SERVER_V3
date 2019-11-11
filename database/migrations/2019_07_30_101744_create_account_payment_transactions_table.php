<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payment_transactions', function (Blueprint $table) {
            $table->increments('id'); //
            $table->unsignedInteger('owner_id')->nullable()->index(); //Enterprise,Organization level
            $table->string('owner_type')->nullable()->index(); //Enterprise,Organization level
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level
            $table->unsignedInteger('transactionable_id')->nullable()->index(); //Payment for: Purchase, Salary, Expense etc
            $table->string('transactionable_type')->nullable()->index(); //Payment for: Purchase, Salary, Expense etc
            $table->unsignedInteger('payment_type_id')->index();
            $table->float('amount',40,2)->default(00.00)->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('payment_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('account_payment_transactions');
    }
}

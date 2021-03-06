<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_supports');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_supports', function (Blueprint $table) {
            $table->increments('id');

            // $table->unsignedInteger('voucher_id')->index();////(DELETE LATER)
            // $table->string('reference_number');////(DELETE LATER)
            // $table->string('account_number')->index(); //(DELETE LATER) //This account number connects Support Doc & Double Entry Ledger to the Real Account Holder e.g Supplier, Customer etc
            // $table->string('trans_name'); ////(DELETE LATER)//Transaction name e.g Cash Deposit Receipt: 

            $table->string('trans_type');//Transactions  type e.g Deposit
            $table->unsignedInteger('transactionable_id'); //Exact Link to Transactions: Purchase Order, Purchase, Bank Transactions
            $table->string('transactionable_type'); //Exact Link to Transactions: Purchase Order, Purchase, Bank Transactions
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_supports');
    }
}

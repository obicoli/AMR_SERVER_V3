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
            $table->unsignedInteger('voucher_id')->nullable()->index();
            $table->string('account_number')->nullable();
            $table->string('trans_type')->nullable();//Transactions  type e.g Deposit
            $table->string('trans_name')->nullable(); //Transaction name e.g Cash Deposit Receipt
            $table->unsignedInteger('transactionable_id')->nullable(); //Exact Link to Transactions: Purchase Order, Purchase
            $table->string('transactionable_type')->nullable(); //Exact Link to Transactions: Purchase Order, Purchase
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

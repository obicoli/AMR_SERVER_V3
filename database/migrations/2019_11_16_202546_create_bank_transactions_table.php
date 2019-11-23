<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transactions');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('bank_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_account_id')->index();
            $table->string('payee')->nullable();
            $table->string('status')->default('Not Ticked');
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('type')->nullable(); //this can be: Account,Customer,Supplier,Transfer,VAT
            $table->unsignedInteger('transactionable_id')->nullable();//This is Supplier,or Customer,Or Account(Polymorphy)
            $table->string('transactionable_type')->nullable();//This is Supplier,or Customer,Or Account(Polymorphy)
            $table->string('transaction_date');
            $table->float('spent',16,2)->default(00.00)->nullable()->index();
            $table->float('received',16,2)->default(00.00)->nullable()->index();
            $table->float('discount',16,2)->default(00.00)->nullable()->index();
            $table->string('comment')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transactions');
    }
}

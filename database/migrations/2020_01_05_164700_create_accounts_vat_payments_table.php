<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use ByTestGear\Accountable\Accountable;

class CreateAccountsVatPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_vat_payments');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_vat_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_account_id');
            $table->unsignedInteger('vat_return_id');
            $table->float('amount',32,2)->default(0.0);
            $table->enum('type',['Payment','Refund'])->default('Payment');
            $table->timestamp('trans_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_vat_payments');
    }
}

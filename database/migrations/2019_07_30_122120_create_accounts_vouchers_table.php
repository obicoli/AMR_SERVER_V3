<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAccountsVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_vouchers');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('credited')->index();
            $table->string('debited')->index();
            $table->string('credited_parent')->index()->nullable();
            $table->string('debited_parent')->index()->nullable();
            $table->float('amount',16,2)->default(00.00);
            $table->string('notes')->nullable();
            $table->string('voucher_date');
            $table->unsignedInteger('owner_id')->nullable()->index();
            $table->string('owner_type')->nullable()->index();
            $table->string('uuid');
            $table->string('transaction_id')->nullable();
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_vouchers');
    }
}

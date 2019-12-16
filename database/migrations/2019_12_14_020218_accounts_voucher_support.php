<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountsVoucherSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_voucher_supports');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_voucher_supports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('voucher_id')->index();
            $table->string('support_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_voucher_supports');
    }
}

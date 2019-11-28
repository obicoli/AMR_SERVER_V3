<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('accounts_banks');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('accounts_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('unique_code')->nullable();
            $table->float('balance',32,2)->default(00.00)->index();
            $table->boolean('status')->default(true)->index();
            $table->boolean('is_default')->default(false)->index();
            $table->unsignedInteger('account_type_id')->nullable()->index();
            $table->unsignedInteger('ledger_account_id')->index()->nullable();
            $table->unsignedInteger('bank_id')->index();
            $table->unsignedInteger('branch_id')->index();
            $table->string('description')->nullable();
            $table->unsignedInteger('owner_id')->index(); //This is Enterprice,Facility,User etc
            $table->string('owner_type')->index(); //This is Enterprice,Facility,User etc
            $table->softDeletes();
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_banks');
    }
}

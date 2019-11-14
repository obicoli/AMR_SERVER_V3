<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountMasterBankBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('account_master_bank_branches');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('account_master_bank_branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('bank_id')->index();
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('account_master_bank_branches');
    }
}

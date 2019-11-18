<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountChartAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('account_chart_accounts');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('account_chart_accounts', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('coa_id')->index();
            $table->string('name')->nullable();
            $table->string('code')->unique();
            $table->string('status')->default('Active');
            $table->string('notes')->nullable();
            $table->string('default_code')->nullable(); //This column link this coa to default system coa
            $table->boolean('is_sub_account')->default(false);
            $table->boolean('is_special')->default(false);
            $table->unsignedInteger('accounts_type_id')->index()->nullable();
            $table->unsignedInteger('default_coa_id')->index()->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch, Company
            $table->string('owning_type')->nullable()->index(); //Facility,Branch, Company
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('account_chart_accounts');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_coas');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_coas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->boolean('sys_default')->default(false); //This show is a default chart of account like: Sales,Inventory,Cash
            $table->boolean('is_special')->default(false); //This show this account is special e.g Sales is special , Cash Sale&Credit Sales is not special
            $table->unsignedInteger('accounts_type_id')->index();
            //$table->unsignedInteger('accounts_nature_id')->index()->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch, Company
            $table->string('owning_type')->nullable()->index(); //Facility,Branch, Company
            $table->text('notes')->nullable();
            $table->string('uuid');
            Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_coas');
    }
}

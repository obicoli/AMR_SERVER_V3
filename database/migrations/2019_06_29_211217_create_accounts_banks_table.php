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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_banks');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->float('balance',32,2)->default(00.00);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('account_type_id')->nullable();
            $table->unsignedInteger('bank_id');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('owner_id'); //This is Enterprice
            $table->string('owner_type')->index(); //this is enterprice
            // $table->unsignedInteger('holder_id')->nullable()->index(); //This is Enterprice individuals
            // $table->string('holder_type')->nullable()->index(); //this is enterprice individuals
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

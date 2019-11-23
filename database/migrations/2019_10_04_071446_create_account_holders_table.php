<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAccountHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('account_holders');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('account_holders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->unsignedInteger("owner_id");
            $table->string("owner_type");
            $table->unsignedInteger("practice_id");
            $table->string("account_type");
            $table->string("account_number")->unique()->index();
            $table->string("name")->nullable();
            $table->double('main', 10, 2)->default(0.00);
            $table->double("bonus", 10, 2)->default(0.00);
            $table->double("balance", 16, 2)->default(0.00);
            $table->softDeletes();
            $table->timestamps();
            \ByTestGear\Accountable\Accountable::columns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('account_holders');
    }
}

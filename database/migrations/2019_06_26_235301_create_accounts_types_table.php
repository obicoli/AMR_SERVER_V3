<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_types');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->nullable();
            $table->unsignedInteger('accounts_nature_id')->index();
            $table->unsignedInteger('accounts_nature_type_id')->nullable()->index();
            $table->string('uuid')->index();
            $table->softDeletes();
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_types');
    }
}

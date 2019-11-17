<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransactionAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transaction_assets');
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->create('bank_transaction_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable()->index();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable()->index();
            $table->unsignedInteger('bank_transaction_id')->index();
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
        Schema::connection(Module::MYSQL_FINANCE_DB_CONN)->dropIfExists('bank_transaction_assets');
    }
}

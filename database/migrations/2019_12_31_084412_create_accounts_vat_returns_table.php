<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsVatReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_tax_returns');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_tax_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('Open');
            $table->string('reference_number');
            $table->string('vat_pin');
            $table->integer('frequency')->default(1);
            $table->timestamp('period_start_date')->nullable();
            $table->timestamp('period_due_date')->nullable();
            $table->timestamp('submission_date')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index()->comment('Polymorphy: Link to facility');
            $table->string('owning_type')->nullable()->index()->comment('Polymorphy: Link to facility');
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_tax_returns');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsTaxReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_tax_return_items');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_tax_return_items', function (Blueprint $table) {
            $table->increments('id');
            // $table->float('taxable_purchase',16,2)->default(0.00);
            // $table->float('taxable_sales',16,2)->default(0.00);
            $table->unsignedInteger('tax_return_id')->index()->comment('This colums references Table:accounts_tax_returns');
            $table->unsignedInteger('accounts_taxation_id')->index()->comment('This colums references Table:accounts_taxations(Which stores tax rates)');
            $table->foreign('tax_return_id')->references('id')->on('accounts_tax_returns')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_tax_return_items');
    }
}

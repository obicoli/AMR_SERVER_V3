<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeTaxVatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_tax_vats');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_tax_vats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('category')->nullable()->index();
            $table->string('description')->nullable();
            $table->string('start_period')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('collected_on_sales')->default(true);
            $table->float('sales_rate')->default(0.00);
            $table->float('purchase_rate')->default(0.00);
            $table->boolean('collected_on_purchase')->default(true);
            $table->boolean('status')->default(true);
//            $table->unsignedInteger('practice_id');
//            $table->unsignedInteger('practice_taxes_id');
//            $table->unsignedInteger('ledger_account_id')->nullable();
            $table->string('uuid');
            $table->softDeletes();
            Accountable::columns($table);
            $table->timestamps();
            $table->unsignedInteger('practice_taxes_id');
            $table->foreign('practice_taxes_id')->references('id')->on('practice_taxes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_tax_vats');
    }
}

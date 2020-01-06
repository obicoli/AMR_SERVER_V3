<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountsTaxationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_taxations');
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->create('accounts_taxations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('agent_name')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->string('registration_number')->nullable();
            $table->string('description')->nullable();
            $table->string('start_period')->nullable();
            $table->string('filling_frequency',5)->default(1);
            $table->string('reporting_method')->nullable();
            $table->boolean('collected_on_sales')->default(true);
            $table->float('sales_rate')->default(0.00);
            $table->float('purchase_rate')->default(0.00);
            $table->boolean('collected_on_purchase')->default(true);
            $table->boolean('status')->default(true);
            //$table->float('amount')->default(00.00)->index();
            $table->string('owner_type')->index();
            $table->unsignedInteger('owner_id')->index();
            $table->string('uuid')->unique();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->dropIfExists('accounts_taxations');
    }
}

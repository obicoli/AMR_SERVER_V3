<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeTaxationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_taxations');
        Schema::create('practice_taxations', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name')->index();
            //$table->string('agent_name')->nullable()->index();
//            $table->string('category')->nullable()->index();
//            $table->string('description')->nullable();
//            $table->string('start_period')->nullable();
            //$table->string('filling_frequency',5)->default(1);
            //$table->string('reporting_method')->nullable();
//            $table->boolean('is_default')->default(false);
//            $table->boolean('collected_on_sales')->default(true);
//            $table->float('sales_rate')->default(0.00);
//            $table->float('purchase_rate')->default(0.00);
//            $table->boolean('collected_on_purchase')->default(true);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('practice_id');
            $table->unsignedInteger('vat_type_id');
            $table->unsignedInteger('ledger_account_id')->nullable();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_taxations');
    }
}

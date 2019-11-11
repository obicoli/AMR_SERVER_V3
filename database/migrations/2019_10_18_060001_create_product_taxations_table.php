<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTaxationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_taxations');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_taxations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('agent_name')->nullable()->index();
            $table->string('registration_number')->nullable();
            $table->string('description')->nullable();
            $table->string('start_period')->nullable();
            $table->string('filling_frequency')->nullable();
            $table->string('reporting_method')->nullable();
            $table->boolean('collected_on_sales')->default(false);
            $table->float('sales_rate')->default(0.00);
            $table->float('purchase_rate')->default(0.00);
            $table->boolean('collected_on_purchase')->default(false);
            $table->boolean('status')->default(true);
            $table->float('amount')->default(00.00)->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_taxations');
    }
}

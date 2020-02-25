<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeCustomerSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_cust_suppl_settings');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_cust_suppl_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('warn_dup_reference')->default(true);
            $table->boolean('warn_dup_invoice_number')->default(true);
            $table->boolean('inactive_customer_processing')->default(true);
            $table->boolean('inactive_customer_reports')->default(true);
            $table->boolean('inactive_suppliers_processing')->default(false);
            $table->boolean('inactive_suppliers_reports')->default(false);
            $table->boolean('use_inclusive_suppliers_docs')->default(true);
            $table->boolean('use_inclusive_customer_docs')->default(true);
            $table->boolean('account_as_default_selection')->default(true);
            $table->unsignedInteger('practice_id')->index();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_cust_suppl_settings');
    }
}

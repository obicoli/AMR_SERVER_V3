<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_payments');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ledger_account_id')->index();
            $table->unsignedInteger('customer_invoice_id')->index();
            $table->unsignedInteger('customer_id')->index();
            $table->timestamp('trans_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->float('amount',32,2)->default(00.00);
            $table->string('status')->default('Paid')->index();
            $table->string('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('trans_number')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_payments');
    }
}

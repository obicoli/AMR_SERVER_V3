<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_payments');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->unsignedInteger('bill_id')->index()->nullable();
            $table->unsignedInteger('ledger_account_id')->index()->nullable();
            $table->timestamp('payment_date')->index()->nullable();
            $table->string('payment_method')->default('Cheque');
            $table->float('amount',32,2)->default(00.00);
            $table->string('status')->default('Paid')->index();
            $table->string('settlement_type',['Full','Partial'])->default('Full')->index();
            $table->string('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('trans_number')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_payments');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSupplierBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bills');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->text('notes')->nullable();
            $table->string('status')->nullable();
            $table->string('taxation_option')->nullable();
            $table->enum('bill_type',['Cash','Credit'])->default('Credit');
            $table->timestamp('bill_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('bill_due_date')->nullable();
            $table->string('order_number')->nullable()->index(); //trans_number
            $table->string('trans_number')->nullable(); //trans_number
            //$table->string('billable_type')->nullable()->index();
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->unsignedInteger('billed_id')->index()->nullable(); //This is mostly PO's
            $table->string('billed_type')->nullable()->index();//This is mostly PO's
            $table->unsignedInteger('payment_term_id')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('ledger_account_id')->nullable()->comment('Inventory Account');
            $table->float('net_total',32,2)->default(00.00);
            $table->float('grand_total',32,2)->default(00.00);
            $table->float('total_tax',32,2)->default(00.00);
            $table->float('total_discount',32,2)->default(00.00);

            $table->string('supplier_invoice_number')->nullable();
            $table->string('delivery_form_number')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bills');
    }
}

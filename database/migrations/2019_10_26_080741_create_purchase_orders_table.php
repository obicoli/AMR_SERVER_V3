<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('purchase_orders');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->unsignedInteger('billing_address_id')->index()->nullable();
            $table->string('terms')->nullable();
            $table->string('trans_number')->nullable();
            $table->string('ship_to')->nullable();
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
            $table->unsignedInteger('shipable_id')->nullable()->index(); //Facility,Branch, Customer: to ship this
            $table->string('shipable_type')->nullable()->index(); //Facility,Branch, Customer: to ship this
            $table->string('taxation_option')->nullable();
            $table->timestamp('po_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('po_due_date')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('uuid');
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->softDeletes();
            $table->timestamps();

            // ->default('Pending');
            //$table->string('purchase_type',10)->default('LPO');
            //$table->string('status',30)->default('Pending Approval')->index();

            // $table->unsignedInteger('owner_id')->nullable()->index(); //Enterprise,Organization level
            // $table->string('owner_type')->nullable()->index(); //Enterprise,Organization level

            // $table->unsignedInteger('deliverable_id')->nullable()->index(); //Facility,Branch level: Facility where delivered
            // $table->string('deliverable_type')->nullable()->index(); //Facility,Branch level: Facility where delivered
            // $table->unsignedInteger('approvable_id')->nullable()->index(); //Facility,Branch level: Who approved this
            // $table->string('approvable_type')->nullable()->index(); //Facility,Branch level: Who approved this
            // $table->unsignedInteger('chargeable_id')->nullable()->index(); //Facility,Branch level: Who cater for cost of this PO
            // $table->string('chargeable_type')->nullable()->index(); //Facility,Branch level: Who cater for cost of this PO
            // $table->unsignedInteger('received_id')->nullable()->index(); //Received By
            // $table->string('received_type')->nullable()->index(); //Received By


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('purchase_orders');
    }
}

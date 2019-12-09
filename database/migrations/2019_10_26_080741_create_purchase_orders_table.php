<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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

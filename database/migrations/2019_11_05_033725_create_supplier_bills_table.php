<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('taxation_option')->nullable();
            $table->timestamp('bill_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('bill_due_date')->nullable();
            $table->string('order_number')->nullable()->index(); //trans_number
            $table->string('trans_number')->nullable(); //trans_number
            $table->string('billable_type')->nullable()->index();
            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->unsignedInteger('billed_id')->index()->nullable();
            $table->string('billed_type')->nullable()->index();
            $table->string('uuid');
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

<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_credit_notes');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_credit_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('trans_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->float('shipping_charges',16,2)->default(0);
            $table->float('adjustment_charges',16,2)->default(0);
            $table->float('overal_discount_rate',8,2)->default(0.0);
            $table->boolean('overal_discount')->default(false);
            $table->text('notes')->nullable();
            $table->enum('sales_basis',['Cash','Credit'])->default('Cash');
            $table->enum('taxation_option',['Inclusive of Tax','Exclusive of Tax','Out of scope of Tax'])->default('Inclusive of Tax');
            $table->text('terms_condition')->nullable();
            $table->unsignedInteger('payment_type_id')->nullable()->index();
            $table->unsignedInteger('salesman_id')->nullable()->index(); //Salesperson: Polymorphy Relation
            $table->string('salesman_type')->nullable()->index();//Salesperson: Polymorphy Relation
            $table->string('uuid');
            $table->unsignedInteger('customer_invoice_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable()->index(); //Customer: Polymorphy Relation
            $table->float('net_total',32,2)->default(00.00);
            $table->float('grand_total',32,2)->default(00.00);
            $table->float('total_tax',32,2)->default(00.00);
            $table->float('total_discount',32,2)->default(00.00);
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_credit_notes');
    }
}

<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_sales_orders');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_sales_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('trans_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp('due_date')->nullable();
            $table->float('shipping_charges',16,2)->default(0);
            $table->float('adjustment_charges',16,2)->default(0);
            $table->float('overal_discount_rate',8,2)->default(0.0);
            $table->boolean('overal_discount')->default(false);
            $table->text('notes')->nullable();
            $table->enum('taxation_option',['Inclusive of Tax','Exclusive of Tax','Out of scope of Tax'])->default('Inclusive of Tax');
            $table->text('terms_condition')->nullable();
            $table->unsignedInteger('payment_type_id')->nullable()->index();
            $table->unsignedInteger('salesman_id')->nullable()->index(); //Salesperson: Polymorphy Relation
            $table->string('salesman_type')->nullable()->index();//Salesperson: Polymorphy Relation
            $table->string('uuid');
            $table->unsignedInteger('customer_id')->nullable()->index(); //Customer: Polymorphy Relation
            $table->unsignedInteger('estimate_id')->nullable()->index();
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->unsignedInteger('payment_term_id')->nullable()->index();

            $table->float('net_total',32,2)->default(00.00);
            $table->float('grand_total',32,2)->default(00.00);
            $table->float('total_tax',32,2)->default(00.00);
            $table->float('total_discount',32,2)->default(00.00);
            
            //$table->string('customer_type')->nullable()->index();//Customer: Polymorphy Relation
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_sales_orders');
    }
}

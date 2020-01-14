<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerSalesOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_sales_order_statuses');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_sales_order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notes')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->string('status')->default('Draft')->index(); //product_requistions_id
            $table->enum('type',['status','action'])->default('status');
            $table->softDeletes();
            Accountable::columns($table);
            $table->unsignedInteger('sales_order_id')->index()->nullable();
            $table->foreign('sales_order_id')->references('id')->on('customer_sales_orders')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_sales_order_statuses');
    }
}

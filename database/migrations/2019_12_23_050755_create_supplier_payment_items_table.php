<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierPaymentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_payment');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_bill_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_bill_id')->index()->nullable();
            $table->unsignedInteger('supplier_payment_id')->index()->nullable();
            $table->float('paid_amount',32,2)->default(00.00);
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_payment');
    }
}

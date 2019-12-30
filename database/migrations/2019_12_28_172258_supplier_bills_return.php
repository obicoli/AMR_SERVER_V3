<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Module\Module;

class SupplierBillsReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bills_returns');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_bills_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_bill_id')->index()->comment('Reference supplier_bills m:m relation');
            $table->unsignedInteger('supplier_return_id')->index()->comment('Reference supplier_returns m:m relation');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bills_returns');
    }
}

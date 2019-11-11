<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateSupplierBillStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_statuses');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_bill_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notes')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->string('status')->default('Draft')->index(); //product_requistions_id
            $table->softDeletes();
            Accountable::columns($table);
            $table->unsignedInteger('supplier_bill_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_bill_statuses');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateSupplierPaymentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_payment_statuses');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_payment_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notes')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->string('status')->default('Paid')->index(); //product_requistions_id
            $table->softDeletes();
            Accountable::columns($table);
            $table->unsignedInteger('supplier_payment_id')->index()->nullable();
            $table->foreign('supplier_payment_id')->references('id')->on('supplier_payments')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_payment_statuses');
    }
}

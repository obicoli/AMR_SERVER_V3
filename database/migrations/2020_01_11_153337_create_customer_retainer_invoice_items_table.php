<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerRetainerInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_retainer_invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('uuid');
            $table->float('amount',16,2)->default(0);
            $table->unsignedInteger('retainer_invoice_id')->index();
            $table->foreign('retainer_invoice_id')->references('id')->on('customer_retainer_invoices')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_retainer_invoice_items');
    }
}

<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerInvoiceRecurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_invoice_recurrences');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_invoice_recurrences', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('email')->nullable();
            $table->string('profile_name');
            $table->string('cc_email')->nullable();
            $table->boolean('cc_copy')->default(false);
            $table->string('frequency')->nullable();
            $table->unsignedInteger('customer_invoice_id');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_invoice_recurrences');
    }
}

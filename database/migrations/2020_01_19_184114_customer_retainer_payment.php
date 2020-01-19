<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CustomerRetainerPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_retainer_payments');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_retainer_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_retainer_id')->index();
            $table->unsignedInteger('customer_payment_id')->index();
            $table->float('paid_amount',16,2)->default(0);
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_retainer_payments');
    }
}

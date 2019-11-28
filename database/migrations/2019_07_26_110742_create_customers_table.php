<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customers');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customers', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('address')->index()->nullable();
            //$table->string('city')->index()->nullable();
            $table->boolean('status')->default(true);
            
            $table->text('notes')->nullable();
            //$table->string('title')->index()->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            //$table->string('middle_name')->nullable()->index();
            //$table->string('company')->nullable()->index();
            // $table->string('postal_code')->nullable()->index();
            // $table->string('country')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('mobile')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('fax')->nullable()->index();

            $table->float("credit_limit",32,2)->default(00.00)->index();
            $table->boolean('cash_sale_customer')->default(false);
            $table->boolean('accept_electronic_invoices')->default(false);
            $table->boolean('old_invoice_receipt_auto_locate')->default(false);
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('salutation')->nullable()->index();
            $table->string('legal_name')->nullable();
            $table->string('display_as');
            $table->string('document_sending_by')->default("Email");
            $table->float("default_discount",32,2)->default(00.00)->index();
            $table->unsignedInteger('default_price_id')->nullable();
            $table->unsignedInteger('default_vat_id')->nullable();
            $table->unsignedInteger('ledger_account_id')->nullable()->index();

            //$table->unsignedInteger('customer_terms_id')->nullable();
            $table->unsignedInteger('payment_term_id')->nullable();
            $table->unsignedInteger('prefered_payment_id')->nullable();
            // $table->float('bill_rate')->nullable(); //account_payment_types
            $table->string('business_id')->nullable()->index();
            $table->float("longitude")->default(1)->index();
            $table->float("latitude")->default(38)->index();
            // $table->unsignedInteger('owner_id');
            // $table->string('owner_type');
            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customers');
    }
}

<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('suppliers');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string("uuid")->unique()->index();
            $table->string("salutation")->nullable()->index();
            $table->string("first_name")->nullable()->index();
            $table->string("last_name")->nullable()->index();
            $table->string('display_as');
            $table->text("notes")->nullable();
            $table->string("logo")->nullable();
            $table->float("longitude")->default(1);
            $table->float("latitude")->default(38);
            $table->float("default_discount",8,2)->default(38);
            $table->float('credit_limit',32,2)->default(00.00);
            $table->string("business_id")->nullable();
            $table->string("tax_reg_number")->nullable();
            $table->string("legal_name");
            $table->unsignedInteger("company_id")->index()->nullable();
            $table->unsignedInteger('ledger_account_id')->nullable();
            $table->string("phone")->index()->nullable();
            $table->string("email")->index()->nullable();
            $table->string("mobile")->index()->nullable();
            $table->unsignedInteger("currency_id")->index()->nullable();
            $table->enum('category',['Local','International'])->default('Local');
            //$table->string("address")->nullable();
            $table->boolean("status")->default(true); //old_invoice_payment_auto_locate
            $table->boolean("old_invoice_payment_auto_locate")->default(false); //
            $table->unsignedInteger("owning_id")->nullable()->index();
            $table->string("owning_type")->nullable()->index();
            $table->unsignedInteger("user_id")->nullable();
            $table->unsignedInteger('default_vat_id')->nullable();
            $table->unsignedInteger('payment_term_id');
            //$table->string("city")->nullable();
            $table->string("website")->nullable();
            $table->string("fax")->nullable();
            $table->string("facebook")->nullable();
            $table->string("twitter")->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->softDeletes();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('suppliers');
    }
}

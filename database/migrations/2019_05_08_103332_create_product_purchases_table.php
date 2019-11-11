<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id')->index(); //Enterprice Level making purchase
            $table->string('owner_type')->index();//Enterprice Level making purchase
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility within Enterprice making
            $table->string('owning_type')->nullable()->index();//Facility within Enterprice making
            $table->unsignedInteger('supplier_id')->index();
            //$table->unsignedInteger('department_id')->nullable()->index();sub_store_id
            $table->unsignedInteger('store_id')->nullable()->index();
            $table->unsignedInteger('sub_store_id')->nullable()->index();
            $table->unsignedInteger('payment_type_id')->nullable()->index();
            //total purchase: to be calculated from ProductPurchaseItem
            //$table->float('total_purchase')->default(00.00);
            //discount offered
            $table->float('discount_offered')->default(00.00);
            $table->timestamp('payment_date')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            //grand total: to be calculated as $total_purchase * ($dicount_allowed/100)
            //$table->float('total_purchase')->default(00.00);
            $table->string('note')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('purchase_method')->default('direct');
            $table->string('status')->default('pending');
            $table->string('uuid')->index()->unique();
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
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
        Schema::dropIfExists('product_purchases');
    }
}

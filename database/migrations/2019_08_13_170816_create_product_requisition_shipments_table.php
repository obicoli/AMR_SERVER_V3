<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateProductRequisitionShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requisition_shipments', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('requested_id')->nullable()->index(); //user requesting
            // $table->string('requested_type')->nullable()->index();//user requesting
            $table->unsignedInteger('approving_id')->nullable()->index(); //user approved
            $table->string('approving_type')->nullable()->index();//user approved
            $table->unsignedInteger('shipping_id')->nullable()->index(); //user shii
            $table->string('shipping_type')->nullable()->index();//user approved
            $table->unsignedInteger('receiving_id')->nullable()->index(); //user approved
            $table->string('receiving_type')->nullable()->index();//user approved
            $table->unsignedInteger('product_requistion_id')->index();
            $table->string('uuid');
            Accountable::columns($table);
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
        Schema::dropIfExists('product_requisition_shipments');
    }
}

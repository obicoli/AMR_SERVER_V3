<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\DB;

class CreateGrnNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id')->index()->nullable();
            $table->unsignedInteger('store_id')->index()->nullable();
            $table->unsignedInteger('sub_store_id')->index()->nullable(); //
            $table->string('transaction_type')->index()->nullable();
            $table->unsignedInteger('checkedby_id')->index()->nullable(); //can be a PO
            $table->string('checkedby_type')->index()->nullable(); //can be a PO
            $table->unsignedInteger('receivedby_id')->index()->nullable(); //can be a PO
            $table->string('receivedby_type')->index()->nullable(); //can be a PO
            $table->unsignedInteger('deliverylocation_id')->index()->nullable(); //can be a PO
            $table->string('deliverylocation_type')->index()->nullable(); //can be a PO
            $table->unsignedInteger('transactionable_id')->index()->nullable(); //can be a PO
            $table->string('transactionable_type')->index()->nullable(); //can be a PO
            $table->string('advise_note')->nullable();
            $table->boolean('accounts_copy')->default(false)->index();
            $table->boolean('supplier_copy')->default(false)->index();
            $table->boolean('store_copy')->default(false)->index();
            $table->string('trans_number')->index()->nullable();
            $table->string('uuid')->index();
            $table->softDeletes();
            $table->timestamp('date_received')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('grn_notes');
    }
}

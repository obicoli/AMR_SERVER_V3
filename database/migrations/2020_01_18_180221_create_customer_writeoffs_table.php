<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomerWriteoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_writeoffs');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('customer_writeoffs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->float('amount',16,2)->default(0);
            $table->timestamp('trans_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->boolean('overal_discount')->default(false);
            $table->text('notes')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('customer_id')->nullable()->index(); //Customer: Polymorphy Relation
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('customer_writeoffs');
    }
}

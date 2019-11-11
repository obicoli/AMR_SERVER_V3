<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimates');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_number')->nullable();
            $table->string('ref_number')->nullable();
            $table->timestamp('estimate_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp('expiry_date')->nullable();
            $table->float('shipping_charges',16,2)->default(0);
            $table->float('adjustment_charges',16,2)->default(0);
            $table->text('notes')->nullable();
            $table->text('terms_condition')->nullable();
            $table->unsignedInteger('payment_type_id')->nullable()->index();
            $table->unsignedInteger('salesman_id')->nullable()->index(); //Salesperson: Polymorphy Relation
            $table->string('salesman_type')->nullable()->index();//Salesperson: Polymorphy Relation
            $table->string('uuid');
            $table->unsignedInteger('customer_id')->nullable()->index(); //Customer: Polymorphy Relation
            $table->string('customer_type')->nullable()->index();//Customer: Polymorphy Relation
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimates');
    }
}

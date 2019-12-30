<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_returns');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_returns', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('supplier_id')->index()->nullable();
            $table->timestamp('return_date')->index()->nullable();
            $table->string('notes')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('trans_number')->nullable();

            $table->float('net_total',32,2)->default(00.00);
            $table->float('grand_total',32,2)->default(00.00);
            $table->float('total_tax',32,2)->default(00.00);
            $table->float('total_discount',32,2)->default(00.00);
            $table->string('taxation_option')->nullable();

            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_returns');
    }
}

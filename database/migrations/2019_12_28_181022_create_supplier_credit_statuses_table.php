<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateSupplierCreditStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_credit_statuses');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_credit_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notes')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->string('status')->default('Paid')->index();
            $table->enum('type',['status','action'])->default('status');
            $table->softDeletes();
            Accountable::columns($table);
            $table->unsignedInteger('supplier_credit_id')->index()->nullable();
            $table->foreign('supplier_credit_id')->references('id')->on('supplier_credits')->onDelete('cascade');
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_credit_statuses');
    }
}

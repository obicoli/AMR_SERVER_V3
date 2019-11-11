<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductRequisitionMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_requisition_movements');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_requisition_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note')->nullable();
            $table->string('uuid');
            $table->unsignedInteger('responsible_id')->nullable()->index();
            $table->string('responsible_type')->nullable()->index();
            $table->string('status')->default('Pending')->index(); //product_requistions_id
            $table->string('product_requistion_id')->index();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_requisition_movements');
    }
}

<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_terms');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_terms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uuid');
            $table->string('notes')->nullable();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_terms');
    }
}

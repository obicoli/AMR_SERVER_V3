<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_companies');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('phone')->nullable()->index();
            $table->string('mobile')->nullable()->index();
            $table->unsignedInteger('country_id')->index()->nullable();
            $table->string('logo')->nullable();
            $table->text('notes')->nullable();
            $table->string('uuid');
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->timestamps();
            $table->unsignedInteger("owner_id")->nullable()->index();
            $table->string("owner_type")->nullable()->index();
            $table->unsignedInteger("owning_id")->nullable()->index();
            $table->string("owning_type")->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_companies');
    }
}

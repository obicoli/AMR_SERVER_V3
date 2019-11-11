<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_addresses');
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->create('supplier_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable()->index();
            $table->string('address')->nullable()->index();
            $table->string('region')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->string('uuid');
            $table->string('postal_code')->nullable()->index();
            $table->unsignedInteger('country_id')->nullable()->index();
            $table->unsignedInteger('supplier_id')->nullable()->index();
            $table->string('zip_code')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->string('fax')->nullable()->index();
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
        Schema::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->dropIfExists('supplier_addresses');
    }
}

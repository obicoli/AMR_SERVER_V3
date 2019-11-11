<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_ASSETS_DB_CONN)->dropIfExists('vehicles');
        Schema::connection(Module::MYSQL_ASSETS_DB_CONN)->create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vhc_name')->nullable();
            $table->string('vhc_number')->nullable();
            $table->string('vhc_id')->nullable();
            $table->string('vhc_chase_number')->nullable();
            $table->string('vhc_engine_number')->nullable();
            $table->timestamp('vhc_date')->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->unsignedInteger('owner_id')->nullable()->index(); //Enterprise,Organization level
            $table->string('owner_type')->nullable()->index(); //Enterprise,Organization level
            $table->unsignedInteger('owning_id')->nullable()->index(); //Facility,Branch level: Facility created this
            $table->string('owning_type')->nullable()->index(); //Facility,Branch level: Facility created this
            Accountable::columns($table);
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_ASSETS_DB_CONN)->dropIfExists('vehicles');
    }
}

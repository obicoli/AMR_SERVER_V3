<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;

class CreatePracticeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_addresses');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address')->nullable();
            $table->unsignedInteger('practice_id')->nullable()->index();
            $table->foreign('practice_id')->references('id')->on('practices');
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_addresses');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;

class CreatePracticeStatutoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_statutories');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_statutories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tax_number')->nullable();
            $table->string('registered_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('entity_type')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->unsignedInteger('practice_id')->index();
            $table->unsignedInteger('country_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_statutories');
    }
}

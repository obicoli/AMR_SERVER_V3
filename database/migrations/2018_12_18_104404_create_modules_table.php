<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('modules');
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string("uuid")->unique();
            $table->string("name")->nullable();
            $table->string("description")->nullable();
            $table->longText("documentation")->nullable();
            $table->softDeletes();
            $table->timestamps();
            \ByTestGear\Accountable\Accountable::columns($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}

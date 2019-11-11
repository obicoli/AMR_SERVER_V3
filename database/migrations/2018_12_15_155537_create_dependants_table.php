<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dependants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('other_name')->nullable();
            $table->string('uuid')->nullable();
            $table->string('relationship')->nullable();
            $table->string('address')->nullable();
            $table->string('phone',30)->nullable();
            $table->unsignedInteger('dependable_id');
            $table->string('dependable_type')->nullable();
            $table->enum('gender',['Male','Female','Other'])->nullable();
            $table->integer('age');
            $table->timestamps();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->softDeletes();
        });
    }

//'relationship',
//'', //1:M polymophy
//'dependable_type', //1:M polymophy

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dependants');
    }
}

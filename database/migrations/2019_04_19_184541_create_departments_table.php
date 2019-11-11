
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('owner_type')->index();
            $table->unsignedInteger('owner_id')->index();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->text('description')->nullable();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->string('uuid')->index()->unique();
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
        Schema::dropIfExists('departments');
    }
}

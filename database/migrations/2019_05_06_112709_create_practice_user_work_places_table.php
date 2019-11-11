<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreatePracticeUserWorkPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_user_work_places', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->nullable()->index();
            $table->unsignedInteger('department_id')->index()->nullable();
            $table->unsignedInteger('store_id')->index()->nullable();
            $table->unsignedInteger('sub_store_id')->index()->nullable();
            $table->unsignedInteger('practice_user_id')->index()->nullable();
            $table->timestamp('started_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ended_at')->nullable();
            $table->boolean('status')->default(true)->index();
            $table->softDeletes();
            $table->string('uuid')->nullable();
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
        Schema::dropIfExists('practice_user_work_places');
    }
}

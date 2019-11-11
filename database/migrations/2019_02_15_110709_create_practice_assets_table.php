<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('asset_type')->default('logo');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable();
            $table->integer('assetable_id')->unsigned()->nullable();
            $table->string('assetable_type')->nullable();
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
        Schema::dropIfExists('practice_assets');
    }
}

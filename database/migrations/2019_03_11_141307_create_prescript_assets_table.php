<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescript_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable();
            $table->unsignedInteger('prescription_id');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
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
        Schema::dropIfExists('prescript_assets');
    }
}

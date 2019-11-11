<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consult_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable();
            $table->unsignedInteger('consultation_id');
            $table->softDeletes();
            \ByTestGear\Accountable\Accountable::columns($table);
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
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
        Schema::dropIfExists('consult_assets');
    }
}

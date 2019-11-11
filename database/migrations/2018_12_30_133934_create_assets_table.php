<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset_type')->default('Profile picture');
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable();
            $table->integer('assetable_id')->unsigned(); //Polymorphic relations: which allow a model(Payment) to belong to more than one other model(Consultation, Appointment, User etc) on a single association(service_id).
            $table->string('assetable_type'); //Consultation, Appointments, User
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
        Schema::dropIfExists('assets');
    }
}

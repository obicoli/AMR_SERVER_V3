<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable();
            $table->integer('owner_id')->unsigned(); //Polymorphic relations: which allow a model(Payment) to belong to more than one other model(Consultation, Appointment, User etc) on a single association(service_id).
            $table->string('owner_type'); //Consultation, Appointments, User
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
        Schema::dropIfExists('product_assets');
    }
}

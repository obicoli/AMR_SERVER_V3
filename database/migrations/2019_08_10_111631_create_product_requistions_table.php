<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\DB;

class CreateProductRequistionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requistions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('owner_id')->nullable(); //Enterprise
            $table->string('owner_type')->nullable();//Enterprise
            $table->string('status')->default('Pending'); //

            $table->string('note')->nullable();
            $table->string('type')->default('Item Request');
            $table->string('trans_number')->nullable();
            $table->timestamp('due_date')->default(DB::raw("CURRENT_TIMESTAMP"));

            $table->unsignedInteger('src_owning_id')->nullable()->index();
            $table->string('src_owning_type')->nullable()->index();
            
            $table->unsignedInteger('src_store_id')->nullable()->index();
            $table->unsignedInteger('src_department_id')->nullable()->index();
            $table->unsignedInteger('src_sub_store_id')->nullable()->index();

            $table->unsignedInteger('dest_owning_id')->nullable()->index();
            $table->string('dest_owning_type')->nullable()->index();

            $table->unsignedInteger('dest_store_id')->nullable()->index();
            $table->unsignedInteger('dest_department_id')->nullable()->index();
            $table->unsignedInteger('dest_sub_store_id')->nullable()->index();

            $table->unsignedInteger('requested_id')->nullable()->index(); //practice user requesting:Poly
            $table->string('requested_type')->nullable()->index();//practice user requesting:Poly

            $table->string('uuid');
            Accountable::columns($table);
            $table->softDeletes();
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
        Schema::dropIfExists('product_requistions');
    }
}

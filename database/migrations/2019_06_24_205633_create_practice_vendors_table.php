<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id');
            $table->string('vendor_type')->default('suppliers');
            $table->text('notes')->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('other_name')->nullable()->index();
            $table->string('middle_name')->nullable()->index();
            $table->string('company')->nullable()->index();
            $table->string('postal_code')->nullable()->index();
            $table->string('country')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('mobile')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('fax')->nullable()->index();
            $table->string('terms')->nullable();
            $table->float('bill_rate')->nullable();
            $table->string('business_id')->nullable()->index();
            $table->float("longitude")->default(1)->index();
            $table->float("latitude")->default(38)->index();
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->softDeletes();
            $table->string('uuid');
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
        Schema::dropIfExists('practice_vendors');
    }
}

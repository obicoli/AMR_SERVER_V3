<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;

class CreateAccountVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_vendors', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('owner_id')->index();
            $table->string('address')->index();
            $table->string('city')->index();
            $table->boolean('status')->default(true);
            $table->string('vendor_type')->default('supplier');
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
            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();
            $table->softDeletes();
            $table->string('uuid');
            Accountable::columns($table);
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
        Schema::dropIfExists('account_vendors');
    }
}

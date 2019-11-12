<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this is a branch in either Pharmacy
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practices');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country')->nullable()->index();
            $table->string('mobile')->unique()->nullable()->index();
            $table->string('email')->unique()->nullable()->index();
            $table->boolean('mail_verified')->default(false);
            $table->boolean('phone_verified')->default(false);
            $table->string('address')->nullable();
            $table->string('date_format')->default('Y-m-d H:i:s');
            $table->enum('category',['Main','Branch'])->default('Branch');
            $table->string('description')->nullable();
            $table->string('city')->nullable()->index();
            $table->string('postal_code')->index();
            $table->string("support_email")->nullable()->index();
            $table->string("sales_email")->nullable()->index();
            $table->string('registration_number')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('type')->default('Hospital')->index(); //Hospital, Clinic, Pharmacy
            $table->string('website')->nullable()->index();
            $table->string("longitude",30)->default("36.809858")->index();
            $table->string("latitude",30)->default("-1.319256")->index();
            $table->string('approval_status',20)->default('pending')->index();
            $table->boolean('status')->default(true);
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owner_type')->index()->nullable();
            $table->string('region')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->string('uuid')->nullable()->index();
            $table->string('propriator_title')->nullable();
            $table->string('propriator_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('industry')->nullable();
            $table->boolean('display_assigned_user')->default(true);
            $table->enum('inventory_increase',['Receive','Bill'])->default('Bill');
            $table->enum('inventory_descrease',['Invoice','Sales Order'])->default('Invoice');
            $table->boolean('warehouse_config')->default(true);
            $table->boolean('batch_tracking')->default(true);
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practices');
    }
}

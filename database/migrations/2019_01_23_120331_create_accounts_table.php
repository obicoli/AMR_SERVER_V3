<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->nullable();
            $table->unsignedInteger("owner_id");
            $table->string("owner_type");
            $table->string("name")->nullable();
            $table->double('main', 10, 2)->default(0.00);
            $table->double("bonus", 10, 2)->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("alter table accounts add column balance double(15,4) as (main + bonus);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}

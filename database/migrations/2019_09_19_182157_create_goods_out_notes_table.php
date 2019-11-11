<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsOutNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('goods_out_notes');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('goods_out_notes', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('note')->nullable();
            $table->string('uuid');

            $table->string('trans_number')->nullable();
            $table->string('trans_type')->nullable();
            $table->unsignedInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->unsignedInteger('store_id')->nullable()->index();
            $table->unsignedInteger('department_id')->nullable()->index();
            $table->unsignedInteger('sub_store_id')->nullable()->index();
            $table->unsignedInteger('owner_id')->nullable();
            $table->string('owner_type')->nullable();
            $table->unsignedInteger('owning_id')->nullable()->index();
            $table->string('owning_type')->nullable()->index();

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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('goods_out_notes');
    }
}

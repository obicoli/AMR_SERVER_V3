<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimate_assets');
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->create('estimate_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('estimate_id')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_mime' )->nullable()->index();
            $table->string('uuid' )->nullable();
            $table->string('file_name' )->nullable();
            $table->string('file_size' )->nullable()->index();
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
        Schema::connection(Module::MYSQL_CUSTOMER_DB_CONN)->dropIfExists('estimate_assets');
    }
}

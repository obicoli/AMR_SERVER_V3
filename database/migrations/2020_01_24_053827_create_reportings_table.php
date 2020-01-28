<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_REPORTS_DB_CONN)->dropIfExists('reportings');
        Schema::connection(Module::MYSQL_REPORTS_DB_CONN)->create('reportings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('section');
            $table->string('description')->nullable();
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
        Schema::connection(Module::MYSQL_REPORTS_DB_CONN)->dropIfExists('reportings');
    }
}

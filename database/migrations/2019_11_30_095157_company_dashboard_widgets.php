<?php

use App\Models\Module\Module;
use ByTestGear\Accountable\Accountable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyDashboardWidgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('company_widgets');
        Schema::connection(Module::MYSQL_DB_CONN)->create('company_widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practice_id')->nullable();
            $table->unsignedInteger('widget_id')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('company_widgets');
    }
}

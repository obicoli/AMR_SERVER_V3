<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use ByTestGear\Accountable\Accountable;
use \App\Models\Module\Module;

class CreatePracticeTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_taxes');
        Schema::connection(Module::MYSQL_DB_CONN)->create('practice_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('obligation')->default('Tax');
            $table->string('tax_number')->unique();
            $table->string('tax_station')->nullable()->index();
            $table->string('agent_name')->nullable()->index();
            $table->enum('reporting_method',['Accrual Basis','Cash Basis'])->default('Accrual Basis');
            $table->string('filling_frequency',5)->default(1);
            $table->string('vat_system')->nullable();
            $table->integer('owner_id');
            $table->string('owner_type')->nullable()->index();
            $table->string('uuid');
            $table->softDeletes();
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
        Schema::connection(Module::MYSQL_DB_CONN)->dropIfExists('practice_taxes');
    }
}

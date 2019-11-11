<?php

use App\Models\Module\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationInventorySmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_notification_sms');
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->create('product_notification_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('Pending');
            $table->string('mobile')->nullable();
            $table->string('message')->nullable();
            $table->integer('resend_count')->default(0);
            $table->string('uuid');
            $table->string('owner_type')->index()->nullable();
            $table->unsignedInteger('owner_id')->index()->nullable();
            $table->string('owning_type')->index()->nullable();
            $table->unsignedInteger('owning_id')->index()->nullable();
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
        Schema::connection(Module::MYSQL_PRODUCT_DB_CONN)->dropIfExists('product_notification_sms');
    }
}

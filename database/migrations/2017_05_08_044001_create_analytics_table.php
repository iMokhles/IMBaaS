<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->increments('id');

            $table->string('event_name');
            $table->text('event_info');

            $table->string('device_id');
            $table->string('device_type');
            $table->string('device_system');
            $table->string('device_os_name');
            $table->string('device_os_version');
            $table->string('device_carrier');
            $table->string('device_resolution');
            $table->string('device_locale');
            $table->string('device_app_version');
            $table->string('device_app_build');
            $table->boolean('device_app_has_watch');
            $table->boolean('device_app_watch_installed');
            $table->integer('device_connection_type');
            $table->float('device_free_ram');
            $table->float('device_total_ram');
            $table->float('device_free_disk');
            $table->float('device_total_disk');
            $table->integer('device_battery_level');
            $table->integer('device_orientation');
            $table->boolean('device_is_jailbroken');

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
        Schema::dropIfExists('analytics');
    }
}

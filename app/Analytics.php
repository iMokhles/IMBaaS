<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'analytics';

    protected $fillable = [
        'event_name', 'event_info',
        'device_id', 'device_type',
        'device_system', 'device_os_name',
        'device_os_version', 'device_carrier',
        'device_resolution', 'device_locale',
        'device_app_version', 'device_app_build',
        'device_app_has_watch', 'device_app_watch_installed',
        'device_connection_type', 'device_free_ram',
        'device_total_ram', 'device_free_disk',
        'device_total_disk', 'device_battery_level',
        'device_orientation', 'device_is_jailbroken'
    ];

}

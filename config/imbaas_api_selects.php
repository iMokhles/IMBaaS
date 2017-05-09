<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 14/04/2017
 * Time: 21:28
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Application API Selects
    |--------------------------------------------------------------------------
    */

    'users_list' => [
        'id',
        'name', 'username',
        'email', 'emailVerified',
        'created_at', 'updated_at'
    ],
    'analytics_list' => [
        'id',
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
        'device_orientation', 'device_is_jailbroken',
        'created_at', 'updated_at'
    ]
];
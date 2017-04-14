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
    | Application Id
    |--------------------------------------------------------------------------
    |
    | Your application id which will be sent from your client
    | to authorize the that client
    |
    |
    */

    'applicationId' => env('API_APPLICATION_ID', 'SomeRandomString'),
    'applicationIdLength' => env('API_APPLICATION_ID_LENGTH', 16),
];
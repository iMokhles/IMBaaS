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
    | Application Id-length-headerKey
    |--------------------------------------------------------------------------
    |
    | Your application id which will be sent from your client
    | to authorize that client
    |
    | Your application id length is your application id length
    |
    | Your application id header key is your application id
    | personal header's key will be sent from your client
    |
    */

    'applicationId' => env('API_APPLICATION_ID', 'TXEIbxMb90zpGIOBkar2q8MnRedYXzE0'),
    'applicationIdLength' => env('API_APPLICATION_ID_LENGTH', 32),
    'applicationIdHeaderKey' => env('API_APPLICATION_ID_HEADER_KEY', 'X_IMBaaS_Application_Id'),
];
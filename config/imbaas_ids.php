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

    'applicationId' => env('API_APPLICATION_ID', '0L5ozw1YbgUnIofF5Egno6RVFFM9YuXG'),
    'applicationIdLength' => env('API_APPLICATION_ID_LENGTH', 32),
    'applicationIdHeaderKey' => env('API_APPLICATION_ID_HEADER_KEY', 'X_IMBaaS_Application_Id'),

    'applicationMasterId' => env('API_APPLICATION_MASTER_ID', '7fz6FATbscbCzE6N6HxcvRNrAsHpUxcH'),
    'applicationMasterIdLength' => env('API_APPLICATION_MASTER_ID_LENGTH', 32),
    'applicationMasterIdHeaderKey' => env('API_APPLICATION_MASTER_ID_HEADER_KEY', 'X_IMBaaS_Master_Id'),
];
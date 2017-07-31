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

    'applicationId' => env('API_APPLICATION_ID', 'ISUOZxon5jxjKdWG2aDuLDwchZG6AwiG'),
    'applicationIdLength' => env('API_APPLICATION_ID_LENGTH', 32),
    'applicationIdHeaderKey' => env('API_APPLICATION_ID_HEADER_KEY', 'X-IMBaaS-Application-Id'),

    'applicationMasterId' => env('API_APPLICATION_MASTER_ID', 'pl2Hyqu8Y1o8H5TaYIhP2u6L6k7o7cef'),
    'applicationMasterIdLength' => env('API_APPLICATION_MASTER_ID_LENGTH', 32),
    'applicationMasterIdHeaderKey' => env('API_APPLICATION_MASTER_ID_HEADER_KEY', 'X-IMBaaS-Master-Id'),
];
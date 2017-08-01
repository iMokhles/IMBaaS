<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group([
        'middleware' => 'api_files',
        'namespace' => 'App\Http\Controllers\Api\Files'], function ($api) {

        // i may implement those commented routes later ( for admin propose ONLY )
//        // get all files
//        $api->get('files', ['as' => 'files.index', 'uses' => 'FilesController@index']);

        // post files
        $api->post('files', ['as' => 'files.store', 'uses' => 'FilesController@store']);

//        // get files
//        $api->get('files/{id}', ['as' => 'files.show', 'uses' => 'FilesController@show']);
//
//        // put files
//        $api->put('files/{id}', ['as' => 'files.update', 'uses' => 'FilesController@update']);
//
//        // delete files
//        $api->delete('files/{id}', ['as' => 'files.destroy', 'uses' => 'FilesController@destroy']);

    });
});
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
        'middleware' => 'api_classes',
        'namespace' => 'App\Http\Controllers\Api\Classes'], function ($api) {

        // get all classes
        $api->get('classes/{className}', ['as' => 'classes.index', 'uses' => 'ClassesController@index']);

        // post classes
        $api->post('classes/{className}', ['as' => 'classes.store', 'uses' => 'ClassesController@store']);

        // get classes
        $api->get('classes/{className}/{id}', ['as' => 'classes.show', 'uses' => 'ClassesController@show']);

        // put classes
        $api->put('classes/{className}/{id}', ['as' => 'classes.update', 'uses' => 'ClassesController@update']);

        // delete classes
        $api->delete('classes/{className}/{id}', ['as' => 'classes.destroy', 'uses' => 'ClassesController@destroy']);

    });
});
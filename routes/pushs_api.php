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
        'middleware' => 'api_pushs',
        'namespace' => 'App\Http\Controllers\Api\Pushs'], function ($api) {

        // get all pushs
        $api->get('pushs', ['as' => 'pushs.index', 'uses' => 'PushsController@index']);

        // post pushs
        $api->post('pushs', ['as' => 'pushs.store', 'uses' => 'PushsController@store']);

        // get pushs
        $api->get('pushs/{id}', ['as' => 'pushs.show', 'uses' => 'PushsController@show']);

        // put pushs
        $api->put('pushs/{id}', ['as' => 'pushs.update', 'uses' => 'PushsController@update']);

        // delete pushs
        $api->delete('pushs/{id}', ['as' => 'pushs.destroy', 'uses' => 'PushsController@destroy']);

    });
});
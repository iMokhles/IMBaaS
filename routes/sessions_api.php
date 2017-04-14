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
        'middleware' => 'api_sessions',
        'namespace' => 'App\Http\Controllers\Api\Sessions'], function ($api) {

        // get all sessions
        $api->get('sessions', ['as' => 'sessions.index', 'uses' => 'SessionsController@index']);

        // get current sessions
        $api->get('sessions/me', ['as' => 'sessions.me', 'uses' => 'SessionsController@me']);

        // post sessions
        $api->post('sessions', ['as' => 'sessions.store', 'uses' => 'SessionsController@store']);

        // get sessions
        $api->get('sessions/{id}', ['as' => 'sessions.show', 'uses' => 'SessionsController@show']);

        // put sessions
        $api->put('sessions/{id}', ['as' => 'sessions.update', 'uses' => 'SessionsController@update']);

        // delete sessions
        $api->delete('sessions/{id}', ['as' => 'sessions.destroy', 'uses' => 'SessionsController@destroy']);

    });
});
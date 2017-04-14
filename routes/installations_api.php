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
        'middleware' => 'api_installations',
        'namespace' => 'App\Http\Controllers\Api\Installations'], function ($api) {

        // get all installations
        $api->get('installations', ['as' => 'installations.index', 'uses' => 'InstallationsController@index']);

        // post installations
        $api->post('installations', ['as' => 'installations.store', 'uses' => 'InstallationsController@store']);

        // get installations
        $api->get('installations/{id}', ['as' => 'installations.show', 'uses' => 'InstallationsController@show']);

        // put installations
        $api->put('installations/{id}', ['as' => 'installations.update', 'uses' => 'InstallationsController@update']);

        // delete installations
        $api->delete('installations/{id}', ['as' => 'installations.destroy', 'uses' => 'InstallationsController@destroy']);

    });
});

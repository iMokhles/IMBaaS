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
        'middleware' => 'api_roles',
        'namespace' => 'App\Http\Controllers\Api\Roles'], function ($api) {

        // get all roles
        $api->get('roles', ['as' => 'roles.index', 'uses' => 'RolesController@index']);

        // post roles
        $api->post('roles', ['as' => 'roles.store', 'uses' => 'RolesController@store']);

        // get roles
        $api->get('roles/{id}', ['as' => 'roles.show', 'uses' => 'RolesController@show']);

        // put roles
        $api->put('roles/{id}', ['as' => 'roles.update', 'uses' => 'RolesController@update']);

        // delete roles
        $api->delete('roles/{id}', ['as' => 'roles.destroy', 'uses' => 'RolesController@destroy']);

    });
});
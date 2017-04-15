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
        'middleware' => 'api_schemas',
        'namespace' => 'App\Http\Controllers\Api\Schemas'], function ($api) {

        // get all schemas
        $api->get('schemas', ['as' => 'schemas.index', 'uses' => 'SchemasController@index']);

        // post schemas
        $api->post('schemas/{className}', ['as' => 'schemas.store', 'uses' => 'SchemasController@store']);

        // get schemas
        $api->get('schemas/{className}', ['as' => 'schemas.show', 'uses' => 'SchemasController@show']);

        // put schemas
        $api->put('schemas/{className}', ['as' => 'schemas.update', 'uses' => 'SchemasController@update']);

        // delete schemas
        $api->delete('schemas/{className}', ['as' => 'schemas.destroy', 'uses' => 'SchemasController@destroy']);

    });
});
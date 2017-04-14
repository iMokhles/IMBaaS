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
        'middleware' => 'api_analytics',
        'namespace' => 'App\Http\Controllers\Api\Analytics'], function ($api) {

        // get all analytics
        $api->get('analytics', ['as' => 'analytics.index', 'uses' => 'AnalyticsController@index']);

        // post analytics
        $api->post('analytics', ['as' => 'analytics.store', 'uses' => 'AnalyticsController@store']);

        // get analytics
        $api->get('analytics/{id}', ['as' => 'analytics.show', 'uses' => 'AnalyticsController@show']);

        // put analytics
        $api->put('analytics/{id}', ['as' => 'analytics.update', 'uses' => 'AnalyticsController@update']);

        // delete analytics
        $api->delete('analytics/{id}', ['as' => 'analytics.destroy', 'uses' => 'AnalyticsController@destroy']);

    });
});
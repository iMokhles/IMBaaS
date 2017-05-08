<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Users API Routes
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
        'middleware' => 'api_users',
        'namespace' => 'App\Http\Controllers\Api\Users'], function ($api) {

        // get all users
        $api->get('users', ['as' => 'users.index', 'uses' => 'UsersController@index']);

        // get current user
        $api->get('users/me', ['as' => 'users.me', 'uses' => 'UsersController@me']);

        // post users
        $api->post('users', ['as' => 'users.store', 'uses' => 'UsersController@store']);

        // get login
        $api->get('users/login', ['as' => 'users.login', 'uses' => 'UsersController@login']);

        // post logout
        $api->post('users/logout', ['as' => 'users.logout', 'uses' => 'UsersController@logout']);

        // post request password
        $api->post('users/requestPasswordReset', ['as' => 'users.requestPasswordReset', 'uses' => 'UsersController@requestPasswordReset']);

        // post request verification email
        $api->post('users/requestVerificationEmail', ['as' => 'users.requestVerificationEmail', 'uses' => 'UsersController@requestVerificationEmail']);

//        // get and verify email verification token
//        $api->get('users/verifyEmail/{token}', ['as' => 'users.verifyEmail', 'uses' => 'UsersController@verifyEmail']);
//
//        // get reset password token and change password
//        $api->get('users/resetPassword/{token}', ['as' => 'users.resetPassword', 'uses' => 'UsersController@resetPassword']);

        // get user
        $api->get('users/{id}', ['as' => 'users.show', 'uses' => 'UsersController@show']);

        // put users
        $api->put('users/{id}', ['as' => 'users.update', 'uses' => 'UsersController@update']);

        // delete users
        $api->delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']);

    });
});
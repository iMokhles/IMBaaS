<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/error/{error_number}', function ($error_number) {
    return view('errors.error',['error_number' => $error_number]);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/users/verifyEmail/{token}', 'Api\Users\UsersController@verifyEmail')->name('users.verifyEmail');
Route::get('/users/resetPassword/{token}', 'Api\Users\UsersController@resetPassword')->name('users.resetPassword');

Route::get('/files/{ext}/{md5}/{filename}', 'Api\Files\FilesController@getFile')->name('users.getFile');


Route::get('/routes', 'HomeController@routes');
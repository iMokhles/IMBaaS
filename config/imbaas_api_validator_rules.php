<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 14/04/2017
 * Time: 21:28
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Application API Validator Rules
    |--------------------------------------------------------------------------
    */

    'user_signup_rules' => [
        'name' => 'required|max:255',
        'username' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed|alpha_dash'
    ],

    'user_login_rules' => [
        'email' => 'required|email|max:255',
        'password' => 'required|min:6|alpha_dash',
    ],

    'user_update_rules' => [

    ],


];
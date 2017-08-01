<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 01/08/2017
 * Time: 03:05
 */

namespace App\Helpers;


use Illuminate\Http\Response;

class BaseHelper
{
    protected static function sendResponse($message, $error_code)
    {
        return response()->json([
            'results' => $message,
            'status' => Response::$statusTexts[$error_code],
            'status_code' => $error_code
        ])->setStatusCode($error_code, Response::$statusTexts[$error_code]);
    }
}
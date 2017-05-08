<?php

namespace App\Http\Controllers\Api\Base;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BaseController extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendResponse($message, $error_code)
    {
        return response()->json([
            'info' => $message,
            'status' => Response::$statusTexts[$error_code],
            'status_code' => $error_code
        ])->setStatusCode($error_code, Response::$statusTexts[$error_code]);
    }
}

<?php

namespace App\Http\Controllers\Api\Files;

use App\Helpers\FilesHelper;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilesController extends Controller
{

    public $class_name = "files";

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return FilesHelper::uploadFile($request);
    }

    public function getFile($ext, $md5, $filename) {
        return FilesHelper::getFile($ext, $md5, $filename);
    }
}

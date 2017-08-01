<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 31/07/2017
 * Time: 17:44
 */

namespace App\Helpers;


use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Fractal\Fractal;
use Tymon\JWTAuth\Facades\JWTAuth;

class FilesHelper extends BaseHelper
{
    protected static $class_name = "files";

    public static function getUniqueFileId() {
        $code = null;
        do
        {
            $code = Str::random(20);
            $user_code = Helpers::first(self::$class_name, ["filename" => $code]);
        }
        while(!empty($user_code));
        return $code;
    }
    public static function getUniqueFolderId() {
        $code = null;
        do
        {
            $code = md5(Str::random(20));
            $user_code = Helpers::first(self::$class_name, ["md5" => $code]);
        }
        while(!empty($user_code));
        return $code;
    }

    public static function uploadFile(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user) {

            if (!is_executable($request->file)) {
                $size = $request->file->getClientSize();
                $content_type = $request->file->getMimeType();
                $extension = $request->file->getClientOriginalExtension();
                $file_unique_name = self::getUniqueFileId();
                $md5_folder = md5(self::getUniqueFolderId());

                $path = Storage::disk('storage')->putFileAs(
                    "files/$extension/$md5_folder", $request->file, $file_unique_name.".".$extension
                );

                $file_url = url("files/$extension/$md5_folder/$file_unique_name");
                if (strlen($path) > 5) {
                    $file_saved = Helpers::insertToTable(self::$class_name, [
                        "user_id" => $user->id,
                        "ext" => $extension,
                        "md5" => $md5_folder,
                        "filename" => $file_unique_name,
                        "content_type" => $content_type,
                        "size" => $size,
                        "url" => $file_url
                    ]);
                    if ($file_saved != null) {
                        return self::sendResponse(['messages' => config('imbaas_messages.file_uploaded'), 'url' => $file_url], Response::HTTP_OK);
                    } else {
                        // couldn't save it to database ( remove it from storage and warn the user )
                        Storage::delete("files/$extension/$md5_folder/$file_unique_name");
                        Storage::deleteDirectory("files/$extension/$md5_folder");
                        return self::sendResponse(config('imbaas_messages.invalid_action'), Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }
            } else {
                // we don't support executable files
            }
        }

    }
    public static function getFile($ext, $md5, $filename) {
        $file = Helpers::first(self::$class_name, [
            'md5' => $md5,
            'filename' => $filename,
            'ext' => $ext
        ]);
        if ($file != null) {
            $file_path = storage_path("files/$ext/$md5/$filename.$ext");
            return response()->file($file_path, [
                "Content-Length" => $file->size,
                "Content-Type" => $file->content_type,
                "Content-disposition" => "attachment; filename=\"".$filename."\"",
            ]);
        } else {
            return abort(404);
        }
    }
}
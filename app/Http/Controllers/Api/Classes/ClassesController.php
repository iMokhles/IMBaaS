<?php

namespace App\Http\Controllers\Api\Classes;

use App\Helpers\Helpers;
use App\Http\Controllers\Api\Base\BaseController;
use App\Transformers\FileTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Fractal\Fractal;

class ClassesController extends BaseController
{

    /**
     * Display a listing of the resource.
     * Example: /users
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $className)
    {

        $defaultLimit = 100;

        if ($request->has('where') && $request->has('order')) {
            return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
        }

        $table = $className;

        if ($request->has('select')) {
            if (str_contains(strtolower($request['select']), ['password'])) {
                return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
            }
            $query = DB::table($table)->select(DB::raw($request['select']));
        } else {
            if (config('imbaas_settings.allowTransformers') == true) {
                $query = DB::table($table)->select('*');
            } else {
                $className_low = strtolower($className);
                $query = DB::table($table)->select(config("imbaas_api_selects.{$className_low}_list"));
            }
        }
        if ($request->has('skip')) {
            $query = $query->skip($request['skip'], $defaultLimit);
        }

        if ($request->has('where')) {
            $whereObject = $request['where'];
            $whereObject = json_decode($whereObject);
            foreach ($whereObject as $key => $value) {
                $query = $query->where([
                    $key => $value
                ]);
            }
        }

        if ($request->has('limits')) {
            $query = $query->take($request['limits'], $defaultLimit);
        }

        if ($request->has('order')) {
            $orderObject = $request['order'];
            $orderObject = json_decode($orderObject);
            foreach ($orderObject as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }
        if ($request->has('paginate')) {
            $results = $query->paginate($request['paginate']);
        } else {
            $results = $query->get();
        }

        if (config('imbaas_settings.allowTransformers') == true) {
            if ($className == "users") {
                $results = Fractal::create()
                    ->collection($results)
                    ->transformWith(new UserTransformer())
                    ->toArray();
            } else if ($className == "files") {
                $results = Fractal::create()
                    ->collection($results)
                    ->transformWith(new FileTransformer())
                    ->toArray();
            }

        }

        return $this->sendResponse($results, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * EXAMPLE: columns = {"name": "test account", "username": "itest_account", "email": "test_account@aol.com", "password": "123456"}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $className)
    {
        if (!Schema::hasTable($className)) {
            return $this->sendResponse("you do not have {$className} class", Response::HTTP_BAD_REQUEST);
        }
        // class already here check columns
        $columns = $request['columns'];
        $columns = json_decode($columns);

        $columns_copy = [];
        foreach ($columns as $k=>$v) {
            if (!Schema::hasColumn($className, $k)) {
                return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
            }
            $columns_copy[$k] = $v;
        }
        if ($className == "users") {
            if (isset($columns->password)) {
                $columns_copy['password'] = bcrypt($columns_copy['password']);
            }
            $columns_copy['emailVerified'] = false;
        }
        $objectCreated = Helpers::insertToTable($className, $columns_copy);
        if ($objectCreated != null) {
            return $this->sendResponse("Created Object with Id $objectCreated in $className Class ".Config::get('imbaas_messages.object_created'), Response::HTTP_OK);
        }
        return $this->sendResponse(config('imbaas_messages.invalid_action'), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     * Example: /users/1
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($className, $id) {
        $object = Helpers::first($className, $id);
        if ($object == null) {
            return $this->sendResponse(config('imbaas_messages.object_not_found'), Response::HTTP_BAD_REQUEST);
        }
        $results = [];
        if (config('imbaas_settings.allowTransformers') == true) {
            if ($className == "users") {
                $results = Fractal::create()
                    ->collection([$object])
                    ->transformWith(new UserTransformer())
                    ->toArray();
            } else if ($className == "files") {
                $results = Fractal::create()
                    ->collection([$object])
                    ->transformWith(new FileTransformer())
                    ->toArray();
            }
        }
        return $this->sendResponse($results, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * EXAMPLE1: fields:{"score": {"decrement": "20"}}
     * EXAMPLE2: fields:{"score": {"increment": "23"}}
     * EXAMPLE3: fields:{"name": "imokhles", "email": "imokhles@aol.fr", "username": "Mokhlas", "score": {"increment": "1"}}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $className, $id) {
        $object = Helpers::first($className, $id);

        $fields = $request['fields'];
        $fields = json_decode($fields);

        if ($className == "users") {
            if (isset($fields->password) || isset($fields->emailVerified)) {
                return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
            }
        }
        foreach ($fields as $k=>$v) {
            if (isset($v->increment)) {
                $type = DB::connection()->getDoctrineColumn($className, $k)->getType()->getName();
                if ($type == "integer") {
                    $item = $object->$k;
                    Helpers::updateRecord($className, $id, [
                        $k => $item+$v->increment
                    ]);
                } else {
                    return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
                }

            } else if (isset($v->decrement)) {
                $type = DB::connection()->getDoctrineColumn($className, $k)->getType()->getName();
                if ($type == "integer") {
                    $item = $object->$k;
                    Helpers::updateRecord($className, $id, [
                        $k => $item-$v->decrement
                    ]);
                } else {
                    return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
                }

            } else {
                Helpers::updateRecord($className, $id, [
                    $k => $v
                ]);
            }
        }
        return $this->sendResponse("Object With Id {$object->id} in $className Class ".Config::get('imbaas_messages.object_updated'), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * Example: /users/1
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($className, $id) {
        $objectDeleted = Helpers::delete($className, $id);
        if ($objectDeleted) {
            return $this->sendResponse(Config::get('imbaas_messages.object_deleted'), Response::HTTP_OK);
        }
        return $this->sendResponse(config('imbaas_messages.invalid_action'), Response::HTTP_BAD_REQUEST);
    }
}

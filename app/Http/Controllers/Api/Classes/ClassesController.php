<?php

namespace App\Http\Controllers\Api\Classes;

use App\Helpers\Helpers;
use App\Http\Controllers\Api\Base\BaseController;
use App\Transformers\FileTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Fractal\Fractal;

class ClassesController extends BaseController
{

    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $className)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($className, $id)
    {
        $object = Helpers::first($className, $id);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $className, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($className, $id)
    {
        //
    }
}

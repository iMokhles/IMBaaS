<?php

namespace App\Http\Controllers\Api\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public $class_name = "analytics";
    public $model = "\App\Analytics";

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $defaultLimit = 100;
        if ($request->has('where') && $request->has('order')) {
            return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
        }
        $table = $this->class_name;

        if ($request->has('select')) {
            if (str_contains(strtolower($request['select']), ['password'])) {
                return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
            }
            $query = DB::table($table)->select(DB::raw($request['select']));
        } else {
            if (config('imbaas_settings.allowTransformers') == true) {
                $query = DB::table($table)->select('*');
            } else {
                $query = DB::table($table)->select(config('imbaas_api_selects.analytics_list'));
            }

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

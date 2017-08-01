<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' =>[
            'routes'
        ]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function routes() {
        $app = app();
        $routes = $app->routes->getRoutes();

        Artisan::call('api:routes');
        return '<pre>' . Artisan::output() . '</pre>';
        return view ('routes',compact('routes'));
    }
}

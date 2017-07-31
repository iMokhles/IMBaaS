<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $this->data['statics'] = $this->dashboardStatics();

        return view('backpack::dashboard', $this->data);
    }

    protected function dashboardStatics() {

        return [
            [
                'color' => 'red',
                'title' => 'Users',
                'icon' => 'fa-users',
                'count' => count(Helpers::all("users")),
            ],
            [
                'color' => 'yellow',
                'title' => 'Installations',
                'icon' => 'fa-arrow-down',
                'count' => count(Helpers::all("installations")),
            ],
            [
                'color' => 'light-blue',
                'title' => 'Files',
                'icon' => 'fa-file',
                'count' => count(Helpers::all("files")),
            ],
            [
                'color' => 'maroon-active',
                'title' => 'Push Sent',
                'icon' => 'fa-exclamation-triangle',
                'count' => count(Helpers::all("pushs")),
            ],
            [
                'color' => 'green-active',
                'title' => 'Active Sessions',
                'icon' => 'fa-check-circle',
                'count' => count(Helpers::allWhere("sessions", ["active" => true])),
            ],
            [
                'color' => 'navy-active',
                'title' => 'Unverified Users',
                'icon' => 'fa-user-times',
                'count' => count(Helpers::allWhere("users", ["emailVerified" => false])),
            ],
            [
                'color' => 'red-active',
                'title' => 'Verified Users',
                'icon' => 'fa-user-plus',
                'count' => count(Helpers::allWhere("users", ["emailVerified" => true])),
            ],
            [
                'color' => 'purple',
                'title' => 'Classes',
                'icon' => 'fa-stack-overflow',
                'count' => count(Helpers::all("classes")),
            ],
        ];
    }
    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(config('backpack.base.route_prefix').'/dashboard');
    }
}

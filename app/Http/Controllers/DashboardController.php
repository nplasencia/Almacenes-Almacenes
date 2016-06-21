<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $icon  = 'fa fa-dashboard';
    protected $title = 'menu.dashboard';
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function resume()
    {
        return view('dashboard', ['title' => trans($this->title), 'icon' => $this->icon]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->resume();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

    public function stock()
    {
        return view('stock');
    }

    public function recipes()
    {
        return view('recipes');
    }

    public function shopping_list()
    {
        return view('shopping_list');
    }

    public function sensors()
    {
        return view('sensors');
    }

    public function settings()
    {
        return view('settings');
    }
}

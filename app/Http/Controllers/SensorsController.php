<?php

namespace App\Http\Controllers;

use App\Beacons;
use App\Weight;
use Illuminate\Http\Request;

class SensorsController extends Controller
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

    public function sensors()
    {
        return view('sensors');
    }
}

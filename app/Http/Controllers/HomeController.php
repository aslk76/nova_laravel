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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mplus()
    {
        return view('mplus');
    }
    public function various()
    {
        return view('various');
    }
    public function mplusArchives()
    {
        return view('archives.mplus');
    }
    public function variousArchives()
    {
        return view('archives.various');
    }
    public function mplusMissing()
    {
        return view('missing.mplus');
    }
    public function variousMissing()
    {
        return view('missing.various');
    }
    public function balanceops()
    {
        return view('balanceops');
    }
}

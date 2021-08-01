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

    public function home()
    {
        return view('home');
    }
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
    public function topboosters()
    {
        return view('topboosters');
    }
    public function statistics()
    {
        return view('statistics');
    }
    public function payments()
    {
        return view('payments');
    }
    public function missingPayments()
    {
        return view('missingpayments');
    }
    public function balance()
    {
        return view('balance');
    }
    public function collections()
    {
        return view('collections');
    }
    public function raids()
    {
        return view('raids');
    }
    public function raidsArchives()
    {
        return view('archives.raids');
    }
    public function raidsMissing()
    {
        return view('missing.raids');
    }
}

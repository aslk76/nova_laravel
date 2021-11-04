<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\RaidCollecting;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
class DatabaseController extends Controller
{
    public function sendRaidToDB(Request $request) {
        dd($request);
    }
}

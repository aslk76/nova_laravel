<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Auth;
use App\RaidCollecting;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
class ApiController extends Controller
{
    public function sendRaidToDB(Request $request) {
        dd($request);
    }
}

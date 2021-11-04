<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Auth;
use App\RaidCollecting;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller as Controller;

class ApiController extends Controller
{
    public function sendRaidToDB(Request $request) {
        dd($request);
        $values = DB::select("SELECT raid_book.advertiser_name AS `name`, realms_paid.name AS paidin, raid_book.paid AS amount, realms_adv.name AS advertiser_realm
        FROM `nova_applications`.raid_book
        LEFT JOIN `nova_applications`.realms realms_paid ON raid_book.paid_realm_id = realms_paid.id
        LEFT JOIN `nova_applications`.realms realms_adv ON raid_book.adv_realm_id  = realms_adv.id
        WHERE raid_id = " + $request->id);

        dd($values);
    }
}

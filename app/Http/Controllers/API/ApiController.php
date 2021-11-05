<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\RaidCollecting;
use App\RaidBalance;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller as Controller;

class ApiController extends Controller
{
    public function sendRaidToDB(Request $request) {
        $values = DB::select("SELECT raid_book.advertiser_name AS `name`, realms_paid.name AS paidin, raid_book.paid AS amount, realms_adv.name AS advertiser_realm
        FROM `nova_applications`.raid_book
        LEFT JOIN `nova_applications`.realms realms_paid ON raid_book.paid_realm_id = realms_paid.id
        LEFT JOIN `nova_applications`.realms realms_adv ON raid_book.adv_realm_id  = realms_adv.id
        WHERE raid_id = ". $request->id);

        foreach ($values as $value) {
            $collect = new RaidCollecting;
            $collect->import_date = date('Y-m-d');
            $collect->name = $value->name;
            $collect->paidin = $value->paidin;
            $collect->amount = $value->amount;
            $collect->save();
        }

        if (date('D') == 'Tue') {
            $date = date('Y-m-d');
        } else {
            $timestamp = strtotime('next tuesday');
            $date = date('Y-m-d', $timestamp);
        }
        $values = collect(\DB::select("SELECT leader_id, guild_id, boosters, rl_cut, booster_cut from `nova_applications`.raid where id = " . $request->id))->first();
        if (!is_null($values->guild_id)) {
            $grep = collect(\DB::select("SELECT pay_character from `nova_applications`.guilds where id = ".$values->guild_id))->first();
            $grep = explode("-", $grep->pay_character);
            $balance = new RaidBalance;
            $balance->import_date = $date;
            $balance->name = $grep[0];
            $balance->realm = $grep[1];
            $balance->amount = $values->rl_cut + $values->booster_cut;
            $balance->save();
        } else {
            $boosters = str_replace(["[","]"],"",$values->boosters);
            $boosters = explode(",", $boosters);
            dd($boosters);
        }
    }
}

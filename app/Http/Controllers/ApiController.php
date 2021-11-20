<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use App\RaidCollecting;
use App\RaidBalance;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function sendRaidToDB(Request $request) {
        try {
            $imports = array();

            $values = DB::select("SELECT raid_book.advertiser_name AS `name`, realms_paid.name AS paidin, raid.date_and_time, raid_book.paid AS amount, realms_adv.name AS advertiser_realm, user_id, inhouse_ticket, client_ticket, collector
            FROM `nova_applications`.raid_book
            LEFT JOIN `nova_applications`.realms realms_paid ON raid_book.paid_realm_id = realms_paid.id
            LEFT JOIN `nova_applications`.realms realms_adv ON raid_book.adv_realm_id  = realms_adv.id
            INNER JOIN `nova_applications`.raid ON raid_book.raid_id = raid.id
            WHERE raid_id = ". $request->id." AND raid_book.deleted_at is null");

            $raidTime = strtotime($values[0]->date_and_time);
             if (date('D', $raidTime) == 'Tue') {
                $date = date('Y-m-d', $raidTime);
            } else {
                $timestamp = strtotime('next tuesday', $raidTime);
                $date = date('Y-m-d', $timestamp);
            }
            $faction = collect(\DB::select("SELECT faction, type_id from `nova_applications`.raid where id = ".$request->id))->first();
            foreach ($values as $value) {
                //REMOVED TEMP - 20/11/2021
                // $collect = new RaidCollecting;
                // $collect->import_date = date('Y-m-d');
                // $collect->name = $value->name;
                // $collect->paidin = $value->paidin;
                // $collect->amount = $value->amount;
                // $collect->save();
                if (is_null($value->collector)) {
                    $fullname = collect(\DB::select("SELECT name, staff_name, discord_rank from `nova_applications`.users where id = ".$value->user_id))->first();
                    if (!is_null($fullname->staff_name)) {
                        $splitname = explode("-", $fullname->staff_name);
                    } else {
                        $splitname = explode("-", $fullname->name);
                    }
                } else {
                    $fullname = $value->name.'-'.$value->advertiser_realm;
                    $splitname = explode("-", $fullname);
                }

                if ($faction->type_id != 3) {
                    if (is_null($value->collector)) {
                        $roles = str_replace(["[\"","\"]"],"",$fullname->discord_rank);
                        $roles = str_replace(["\"","\""],"",$roles);
                        $roles = explode(",", $roles);
                        if ($faction->faction == "horde" && array_search('Hotshot Advertiser [H]', $roles) >= 0) {
                            $advpot = $value->amount*0.21;
                        } elseif ($faction->faction == "alliance" && array_search('Hotshot Advertiser [A]', $roles) >= 0) {
                            $advpot = $value->amount*0.21;
                        } elseif ($faction->faction == "horde") {
                            $advpot = $value->amount*0.17;
                        } elseif ($faction->faction == "alliance") {
                            $advpot = $value->amount*0.20;
                        }

                        if ($value->inhouse_ticket == 1) {
                            $advpot = $value->amount * 0.07;
                        } elseif ($value->client_ticket == 1) {
                            $advpot = $value->amount*0.10;
                        }
                    } else {
                        if ($faction->faction == "horde") {
                            $advpot = $value->amount*0.17;
                        } elseif ($faction->faction == "alliance") {
                            $advpot = $value->amount*0.20;
                        }
                    }
                } else {
                    if ($value->inhouse_ticket == 1) {
                        $advpot = $value->amount * 0;
                    } elseif ($value->client_ticket == 1) {
                        $advpot = $value->amount*0.05;
                    } else {
                        $advpot = $value->amount*0.10;
                    }
                }

                $el = [
                    "date" => $date,
                    "splitname" => $splitname,
                    "pot" => $advpot,
                ];

                array_push($imports, $el);
                // DB::transaction(function () use ($date, $splitname, $advpot) {
                //     DB::statement("INSERT INTO `raid_balance` (`import_date`,`name`,`realm`,`amount`)
                //     VALUES ('".$date."', '".$splitname[0]."', '".addslashes($splitname[1])."', ".$advpot.")
                //     ON DUPLICATE KEY UPDATE
                //     `import_date`=VALUES(`import_date`), `amount`=`amount`+VALUES(`amount`);");
                // }, 60);
            }

            $values = DB::select("SELECT user_id, guild_id, payment_character, cut from `nova_applications`.raid_cuts where raid_id = ".$request->id);

            foreach ($values as $booster) {
                $cut = (string) $booster->cut;
                if (is_null($booster->user_id)) {
                    $name = explode("-", $booster->payment_character);
                    $el = [
                        "date" => $date,
                        "splitname" => $name,
                        "pot" => $cut,
                    ];
                    array_push($imports, $el);
                    // DB::transaction(function () use ($date, $name, $cut) {
                    //     DB::statement("INSERT INTO `raid_balance` (`import_date`,`name`,`realm`,`amount`)
                    //     VALUES ('".$date."', '".$name[0]."', '".addslashes($name[1])."', ".$cut.")
                    //     ON DUPLICATE KEY UPDATE
                    //     `import_date`=VALUES(`import_date`), `amount`=`amount`+VALUES(`amount`);");
                    // }, 60);
                } else {
                    $fullname = collect(\DB::select("SELECT name, staff_name from `nova_applications`.users where id = ".$booster->user_id))->first();
                    if (!is_null($fullname->staff_name)) {
                        $splitname = explode("-", $fullname->staff_name);
                    } else {
                        $splitname = explode("-", $fullname->name);
                    }
                    $el = [
                        "date" => $date,
                        "splitname" => $splitname,
                        "pot" => $cut,
                    ];
                    array_push($imports, $el);

                }
            }
            DB::transaction(function () use ($imports) {
                foreach ($imports as $import) {
                    DB::statement("INSERT INTO `raid_balance` (`import_date`,`name`,`realm`,`amount`)
                    VALUES ('".$import['date']."',
                    '".$import['splitname'][0]."',
                    '".addslashes($import['splitname'][1])."',
                    ".$import['pot'].")
                    ON DUPLICATE KEY UPDATE
                    `import_date`=VALUES(`import_date`), `amount`=`amount`+VALUES(`amount`);");
                }
            }, 60);
            return response()->json('OK', 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('KO', 500);
        }
    }

    public function editBoosterCut(Request $request) {
        try {
            $amountChange = $request->old_pot - $request->new_pot;
            $raidTime = strtotime($request->raid_time);
            if (date('D', $raidTime) == 'Tue') {
                $date = date('Y-m-d', $raidTime);
            } else {
                $timestamp = strtotime('next tuesday', $raidTime);
                $date = date('Y-m-d', $timestamp);
            }

            $fullname = explode("-", $request->user_name);

            DB::transaction(function () use ($date, $fullname, $amountChange) {
                DB::statement("UPDATE raid_balance SET amount = amount - ".$amountChange." WHERE import_date = '".$date."' AND NAME = '".$fullname[0]."' AND realm = '".addslashes($fullname[1])."'");
            }, 60);

            return response()->json('OK', 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json('KO', 500);
        }
    }
}

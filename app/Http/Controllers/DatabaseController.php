<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mplus;
use App\Various;
use App\Balanceops;
use App\TopCurrent;
use App\TopPrevious;
use App\Payments;
use App\Credits;
use App\Paymentsv2;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
class DatabaseController extends Controller
{
    // ########### MPLUS API ############
    public function getAllMplus($weekid)
    {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Mplus::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->where('missing', 0)->get();
        return $items;
    }
    public function getSpecificMplus($id)
    {
        $item = Mplus::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceMplus($weekid) {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->get();
        return $items;
    }

    public function getAllHordeMplus($weekid) {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->get();
        return $items;
    }

    public function changeCheckboxMplus(Request $request) {

            $item = Mplus::where('id', $request->id)->first();
            if ($request->check == 'collected') {
                if ($request->status == true) {
                    $item->collected = 1;
                } elseif ($request->status == false) {
                    $item->collected = 0;
                }
            } elseif ($request->check == 'missing') {
                if ($request->status == true) {
                    $item->missing = 1;
                } elseif ($request->status == false) {
                    $item->missing = 0;
                }
            }
            $item->save();
    }

    public function saveRunMplus(Request $request) {
        $itemDB = Mplus::where('id', $request->item[0]['id'])->first();
        try {
            $itemDB->boost_faction = $request->item[0]['boost_faction'];
            $itemDB->boost_date = $request->item[0]['boost_date'];
            $itemDB->boost_pot = $request->item[0]['boost_pot'];
            $itemDB->boost_realm = $request->item[0]['boost_realm'];
            $itemDB->adv_name = $request->item[0]['adv_name'];
            $itemDB->adv_realm = $request->item[0]['adv_realm'];
            $itemDB->adv_cut = $request->item[0]['adv_cut'];
            $itemDB->tank_name = $request->item[0]['tank_name'];
            $itemDB->tank_realm = $request->item[0]['tank_realm'];
            $itemDB->tank_cut = $request->item[0]['tank_cut'];
            $itemDB->healer_name = $request->item[0]['healer_name'];
            $itemDB->healer_realm = $request->item[0]['healer_realm'];
            $itemDB->healer_cut = $request->item[0]['healer_cut'];
            $itemDB->dps1_name = $request->item[0]['dps1_name'];
            $itemDB->dps1_realm = $request->item[0]['dps1_realm'];
            $itemDB->dps1_cut = $request->item[0]['dps1_cut'];
            $itemDB->dps2_name = $request->item[0]['dps2_name'];
            $itemDB->dps2_realm = $request->item[0]['dps2_realm'];
            $itemDB->dps2_cut = $request->item[0]['dps2_cut'];
            $itemDB->save();
        } catch (Exception $e) {
            return response('Data Error', 400);
        }
        return response('Data OK', 200);
    }


    // ########### VARIOUS API ############
    public function getAllVarious($weekid)
    {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Various::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->where('missing', 0)->get();
        return $items;
    }
    public function getSpecificVarious($id)
    {
        $item = Various::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceVarious($weekid) {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Alliance')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->get();
        return $items;
    }

    public function getAllHordeVarious($weekid) {
        if ($weekid == 1) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 2) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        }
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Horde')->whereBetween('boost_date', [$startday, $endday])->where('collected', 0)->get();
        return $items;
    }

    public function changeCheckboxVarious(Request $request) {

            $item = Various::where('id', $request->id)->first();
            if ($request->check == 'collected') {
                if ($request->status == true) {
                    $item->collected = 1;
                } elseif ($request->status == false) {
                    $item->collected = 0;
                }
            } elseif ($request->check == 'missing') {
                if ($request->status == true) {
                    $item->missing = 1;
                } elseif ($request->status == false) {
                    $item->missing = 0;
                }
            }
            $item->save();
    }
    public function saveRunVarious(Request $request) {
        $itemDB = Various::where('id', $request->item[0]['id'])->first();
        try {
            $itemDB->boost_faction = $request->item[0]['boost_faction'];
            $itemDB->boost_date = $request->item[0]['boost_date'];
            $itemDB->boost_pot = $request->item[0]['boost_pot'];
            $itemDB->boost_realm = $request->item[0]['boost_realm'];
            $itemDB->adv_name = $request->item[0]['adv_name'];
            $itemDB->adv_realm = $request->item[0]['adv_realm'];
            $itemDB->adv_cut = $request->item[0]['adv_cut'];
            $itemDB->tank_name = $request->item[0]['tank_name'];
            $itemDB->tank_realm = $request->item[0]['tank_realm'];
            $itemDB->tank_cut = $request->item[0]['tank_cut'];
            $itemDB->healer_name = $request->item[0]['healer_name'];
            $itemDB->healer_realm = $request->item[0]['healer_realm'];
            $itemDB->healer_cut = $request->item[0]['healer_cut'];
            $itemDB->dps1_name = $request->item[0]['dps1_name'];
            $itemDB->dps1_realm = $request->item[0]['dps1_realm'];
            $itemDB->dps1_cut = $request->item[0]['dps1_cut'];
            $itemDB->dps2_name = $request->item[0]['dps2_name'];
            $itemDB->dps2_realm = $request->item[0]['dps2_realm'];
            $itemDB->dps2_cut = $request->item[0]['dps2_cut'];
            $itemDB->save();
        } catch (Exception $e) {
            return response('Data Error', 400);
        }
        return response('Data OK', 200);
    }

    // ########### MPLUS ARCHIVES API ############
    public function getAllArchivesMplus()
    {
        $items = Mplus::whereNull('deleted_at')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }
    public function getAllAllianceArchivesMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    public function getAllHordeArchivesMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    // ########### VARIOUS ARCHIVES API ############
    public function getAllArchivesVarious()
    {
        $items = Various::whereNull('deleted_at')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }
    public function getAllAllianceArchivesVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    public function getAllHordeArchivesVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('collected', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    // ########### MPLUS MISSING API ############
    public function getAllMissingMplus()
    {
        $items = Mplus::whereNull('deleted_at')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }
    public function getAllAllianceMissingMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    public function getAllHordeMissingMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    // ########### VARIOUS MISSING API ############
    public function getAllMissingVarious()
    {
        $items = Various::whereNull('deleted_at')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }
    public function getAllAllianceMissingVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    public function getAllHordeMissingVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('missing', 1)->orderBy('edited_at', 'DESC')->get();
        return $items;
    }

    // ########### BALANCE OPS API #############
    public function getBalanceOps($weekid)
    {
        if ($weekid == 1) {
            $items = Balanceops::whereNull('deleted_at')->get();
            return $items;
        }
        if ($weekid == 2) {
            $week = DB::select("SELECT cur1, cur2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->cur1));
            $endday = date('Y/m/d', strtotime($week[0]->cur2. ' + 1 day'));
        } elseif ($weekid == 3) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' + 1 day'));
        } elseif ($weekid == 4) {
            $week = DB::select("SELECT pre1, pre2 from variables");
            $startday = date('Y/m/d', strtotime($week[0]->pre1. ' - 7 days'));
            $endday = date('Y/m/d', strtotime($week[0]->pre2. ' - 6 days'));
        }
        $items = Balanceops::whereNull('deleted_at')->whereBetween('date', [$startday, $endday])->get();
        return $items;
    }

    public function getTopBoosters($faction, $weekid) {
        $arrayItems = [];
        if ($weekid == 1) {
            if ($faction == 'Horde') {
                $items = TopCurrent::where('name', 'LIKE', '%[H]')->take(10)->get();
                foreach ($items as $item) {
                    $element = new \stdClass;
                    $element->name = $item->name;
                    $element->balance = $item->Current_Week_Balance;
                    array_push($arrayItems, $element);
                }
            } elseif ($faction == 'Alliance') {
                $items = TopCurrent::where('name', 'LIKE', '%[A]')->take(10)->get();
                foreach ($items as $item) {
                    $element = new \stdClass;
                    $element->name = $item->name;
                    $element->balance = $item->Current_Week_Balance;
                    array_push($arrayItems, $element);
                }
            }
        } elseif ($weekid == 2) {
            if ($faction == 'Horde') {
                $items = TopPrevious::where('name', 'LIKE', '%[H]')->take(10)->get();
                foreach ($items as $item) {
                    $element = new \stdClass;
                    $element->name = $item->name;
                    $element->balance = $item->Previous_Week_Balance;
                    array_push($arrayItems, $element);
                }
            } elseif ($faction == 'Alliance') {
                $items = TopPrevious::where('name', 'LIKE', '%[A]')->take(10)->get();
                foreach ($items as $item) {
                    $element = new \stdClass;
                    $element->name = $item->name;
                    $element->balance = $item->Previous_Week_Balance;
                    array_push($arrayItems, $element);
                }
            }
        }

        return $arrayItems;
    }

    // ########### BALANCE OPS API #############
    public function getSales($weekId) {
        if ($weekId == 1) {
            $items = DB::select("SELECT `name`, `Sales` FROM `Realms_Sales_Earns` ORDER BY 2 DESC");
        } elseif ($weekId == 2) {
            $items = DB::select("SELECT `name`, `Sales` FROM `Realms_Sales_Earns_Last` ORDER BY 2 DESC");
        }
        return $items;
    }
    public function getEarns($weekId) {
        if ($weekId == 1) {
            $items = DB::select("SELECT `name`, `Earns` FROM `Realms_Sales_Earns` ORDER BY 2 DESC");
        } elseif ($weekId == 2) {
            $items = DB::select("SELECT `name`, `Earns` FROM `Realms_Sales_Earns_Last` ORDER BY 2 DESC");
        }
        return $items;
    }

    public function getTotal($weekId) {
        if ($weekId == 1) {
            $items = DB::select("SELECT SUM(`Sales`) as Total FROM `Realms_Sales_Earns`");
        } elseif ($weekId == 2) {
            $items = DB::select("SELECT SUM(`Sales`) as Total FROM `Realms_Sales_Earns_Last`");
        }
        return $items;
    }

    public function showPayments($faction) {
        switch ($faction) {
            case 'alliance':
                $items = Paymentsv2::where('booster', 'LIKE', '%[A]')->get();
                break;
            case 'horde':
                $items = Paymentsv2::where('booster', 'LIKE', '%[H]')->get();
                break;
            case 'all':
                $items = Paymentsv2::all();
                break;
        }

        foreach ($items as $item) {
            $item->pending = $item->pre_balance - $item->paid;
        }
        return $items;
    }
    public function sendPayment(Request $request) {
        try {
            if (is_numeric(preg_replace('/[.,]/', '', $request->item['paid']))) {
                $payment = new Payments();
                $paymentv2 = Paymentsv2::where('booster', '=', $request->item['booster'])->first();
                $payment->booster = $request->item['booster'];
                $payment->paymentdate = date("Y-m-d H:i:s");
                $payment->amount = preg_replace('/[.,]/', '', $request->item['paid']) - $paymentv2->paid;
                $payment->save();

                $paymentv2->timestamps = false;
                $paymentv2->paid = $request->item['paid'];
                $paymentv2->save();
            } else {
                return Response('wrongvalue');
            }
        } catch (Exception $e) {
            Log::error("Error in sendPayment: ". $e);
        }
    }

    public function showMissingPayments($faction) {
        switch ($faction) {
            case 'alliance':
                $items = DB::select("SELECT payments.booster, ov_creds.tot_balance AS total, ov_creds.tot_balance-((ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance) AS paid, (ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance AS missing FROM payments INNER JOIN ov_creds ON payments.booster = ov_creds.booster WHERE payments.booster LIKE '%[A]' GROUP BY 1 ORDER BY 1 ASC");
                break;
            case 'horde':
                $items = DB::select("SELECT payments.booster, ov_creds.tot_balance AS total, ov_creds.tot_balance-((ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance) AS paid, (ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance AS missing FROM payments INNER JOIN ov_creds ON payments.booster = ov_creds.booster WHERE payments.booster LIKE '%[H]' GROUP BY 1 ORDER BY 1 ASC");
                break;
            case 'all':
                $items = DB::select("SELECT payments.booster, ov_creds.tot_balance AS total, ov_creds.tot_balance-((ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance) AS paid, (ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance AS missing FROM payments INNER JOIN ov_creds ON payments.booster = ov_creds.booster GROUP BY 1 ORDER BY 1 ASC");
                break;
        }

        return $items;
    }
    public function sendMissingPayment(Request $request) {
        try {
            if (is_numeric(preg_replace('/[.,]/', '', $request->item['paid']))) {
                $payment = new Payments();
                $beforePaid = DB::select("SELECT ov_creds.tot_balance-((ov_creds.tot_balance-SUM(payments.amount))-ov_creds.cur_balance) AS paid FROM payments INNER JOIN ov_creds ON payments.booster = ov_creds.booster WHERE payments.booster = '".$request->item['booster']."'");
                $payment->booster = $request->item['booster'];
                $payment->paymentdate = date("Y-m-d H:i:s");
                $payment->amount = preg_replace('/[.,]/', '', $request->item['paid']) - $beforePaid[0]->paid;
                $payment->save();
            } else {
                return Response('wrongvalue');
            }
        } catch (Exception $e) {
            Log::error("Error in sendPayment: ". $e);
        }
    }
}

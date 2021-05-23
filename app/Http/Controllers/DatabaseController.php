<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mplus;
use App\Various;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    // ########### MPLUS API ############
    public function getAllMplus()
    {
        $curweek = DB::select("SELECT cur1, cur2 from variables");
        $startday = date('d/m/Y', strtotime($curweek[0]->cur1));
        $endday = date('d/m/Y', strtotime($curweek[0]->cur2));
        $items = Mplus::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->get();
        return $items;
    }
    public function getSpecificMplus($id)
    {
        $item = Mplus::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->get();
        return $items;
    }

    public function getAllHordeMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->get();
        return $items;
    }

    public function changeCheckboxMplus(Request $request) {

            $item = Mplus::where('id', $request->id)->first();
            if ($request->status == true) {
                $item->collected = 1;
            } elseif ($request->status == false) {
                $item->collected = 0;
            }
            $item->save();
    }


    // ########### VARIOUS API ############
    public function getAllVarious()
    {
        $curweek = DB::select("SELECT cur1, cur2 from variables");
        $startday = date('d/m/Y', strtotime($curweek[0]->cur1));
        $endday = date('d/m/Y', strtotime($curweek[0]->cur2));
        $items = Various::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->get();
        return $items;
    }
    public function getSpecificVarious($id)
    {
        $item = Various::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Alliance')->get();
        return $items;
    }

    public function getAllHordeVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Horde')->get();
        return $items;
    }

    public function changeCheckboxVarious(Request $request) {

            $item = Various::where('id', $request->id)->first();
            if ($request->status == true) {
                $item->collected = 1;
            } elseif ($request->status == false) {
                $item->collected = 0;
            }
            $item->save();
    }


    // ########### MPLUS ARCHIVES API ############
    public function getAllArchivesMplus()
    {
        $curweek = DB::select("SELECT cur1, cur2 from variables");
        $startday = date('d/m/Y', strtotime($curweek[0]->cur1));
        $endday = date('d/m/Y', strtotime($curweek[0]->cur2));
        $items = Mplus::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->where('collected', 1)->get();
        return $items;
    }
    public function getSpecificArchivesMplus($id)
    {
        $item = Mplus::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceArchivesMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('collected', 1)->get();
        return $items;
    }

    public function getAllHordeArchivesMplus() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('collected', 1)->get();
        return $items;
    }

    public function changeCheckboxArchivesMplus(Request $request) {

            $item = Mplus::where('id', $request->id)->first();
            if ($request->status == true) {
                $item->collected = 1;
            } elseif ($request->status == false) {
                $item->collected = 0;
            }
            $item->save();
    }

    // ########### VARIOUS ARCHIVES API ############
    public function getAllArchivesVarious()
    {
        $curweek = DB::select("SELECT cur1, cur2 from variables");
        $startday = date('d/m/Y', strtotime($curweek[0]->cur1));
        $endday = date('d/m/Y', strtotime($curweek[0]->cur2));
        $items = Various::whereNull('deleted_at')->whereBetween('boost_date', [$startday, $endday])->where('collected', 1)->get();
        return $items;
    }
    public function getSpecificArchivesVarious($id)
    {
        $item = Various::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceArchivesVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Alliance')->where('collected', 1)->get();
        return $items;
    }

    public function getAllHordeArchivesVarious() {
        $items = Various::whereNull('deleted_at')->where('boost_faction', 'Horde')->where('collected', 1)->get();
        return $items;
    }

    public function changeCheckboxArchivesVarious(Request $request) {

            $item = Various::where('id', $request->id)->first();
            if ($request->status == true) {
                $item->collected = 1;
            } elseif ($request->status == false) {
                $item->collected = 0;
            }
            $item->save();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mplus;

class DatabaseController extends Controller
{
    public function getAll()
    {
        $items = Mplus::whereNull('deleted_at')->get();
        return $items;
    }
    public function getSpecificRun($id)
    {
        $item = Mplus::where('id', $id)->get();
        return $item;
    }
    public function getAllAllianceRuns() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Alliance')->get();
        return $items;
    }

    public function getAllHordeRuns() {
        $items = Mplus::whereNull('deleted_at')->where('boost_faction', 'Horde')->get();
        return $items;
    }

    public function changeCheckbox(Request $request) {

            $item = Mplus::where('id', $request->id)->first();
            if ($request->status == true) {
                $item->collected = 1;
            } elseif ($request->status == false) {
                $item->collected = 0;
            }
            $item->save();
    }
}

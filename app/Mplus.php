<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Mplus extends Model
{
    protected $table = 'm_plus';
    protected $primaryKey = 'id';
    protected $fillable = [ 'boost_faction', 'boost_id', 'boost_date', 'boost_pot', 'boost_realm', 'adv_name', 'adv_realm', 'adv_cut',
                            'tank_name', 'tank_realm', 'tank_cut',
                            'healer_name', 'healer_realm', 'healer_cut',
                            'dps1_name', 'dps1_realm', 'dps1_cut',
                            'dps2_name', 'dps2_realm', 'dps2_cut',
                            'collected', 'deleted_at', 'edited_at'];
    const UPDATED_AT = 'edited_at';

}

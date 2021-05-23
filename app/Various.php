<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Various extends Model
{
    protected $table = 'various';
    protected $primaryKey = 'id';
    protected $fillable = [ 'boost_faction', 'boost_id', 'boost_date', 'boost_pot', 'boost_realm', 'adv_name', 'adv_realm', 'adv_cut',
                            'tank_name', 'tank_realm', 'tank_cut',
                            'collected', 'deleted_at', 'edited_at'];
    const UPDATED_AT = 'edited_at';

}

<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Credits extends Model
{
    protected $table = 'ov_creds';
    protected $primaryKey = 'id';
    protected $fillable = [ 'booster', 'cur_balance', 'pre_balance', 'tot_balance'];

}

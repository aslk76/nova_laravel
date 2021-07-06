<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Paymentsv2 extends Model
{
    protected $table = 'paymentsv2';
    protected $primaryKey = 'booster';
    protected $keyType = "string";
    protected $fillable = ['booster', 'pre_balance', 'paid', 'totalpaid' ];

}

<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Payments extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [ 'booster', 'paymentdate', 'amount' ];
    const UPDATED_AT = 'updated_at';

}

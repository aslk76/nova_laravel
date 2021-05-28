<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Balanceops extends Model
{
    protected $table = 'balance_ops';
    protected $primaryKey = 'id';
    protected $fillable = [ 'operation_id', 'date', 'name', 'realm', 'operation', 'command', 'reason', 'author',
                            'deleted_at', 'edited_at'];
    const UPDATED_AT = 'edited_at';

}

<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class RaidBalance extends Model
{
    protected $table = 'raid_balance';
    protected $primaryKey = 'id';
    protected $fillable = [ 'import_date', 'name', 'realm', 'amount'];
    const EDITED_AT = 'edited_at';
    const DELETED_AT = 'deleted_at';

}

<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class RaidCollecting extends Model
{
    protected $table = 'raid_collecting';
    protected $primaryKey = 'id';
    protected $fillable = [ 'import_date', 'name', 'paidin', 'amount', 'collected', 'missing', 'edited_at'];
    const EDITED_AT = 'edited_at'

}

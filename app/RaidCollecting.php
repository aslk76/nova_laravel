<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class RaidCollecting extends Model
{
    protected $table = 'raid_collecting';
    protected $primaryKey = 'id';
    protected $fillable = [ 'import_date', 'name', 'paidin', 'raid_name', 'raid_time', 'amount', 'collected', 'missing', 'edited_at' ];
    const EDITED_AT = 'edited_at';
    const UPDATED_AT = 'updated_at';

}

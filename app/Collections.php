<?php

namespace App;


use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Collections extends Model
{
    protected $table = 'collectors';
    protected $primaryKey = 'id';
    protected $fillable = [ 'collection_id', 'collector', 'trialadv', 'realm', 'realm', 'amount', 'date_collected', 'author', 'deleted_at'];
    const DELETED_AT = 'deleted_at';

}

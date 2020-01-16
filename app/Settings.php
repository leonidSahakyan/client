<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Settings extends Model
{
    protected $table = 'settings';

    public $timestamps  = false;

    protected $fillable = [
        'value',
    ];

}

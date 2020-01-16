<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Agents extends Model
{
    protected $table = 'agents';

    public $timestamps  = false;

    protected $fillable = [
        'name', 'email', 'phone','type'
    ];
}

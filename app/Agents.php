<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $table = 'agents';

    protected $primaryKey = 'id';

    public $timestamps  = true;

    protected $fillable = [
        'name', 'email', 'phone','type'
    ];
}

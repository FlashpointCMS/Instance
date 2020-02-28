<?php

namespace Flashpoint\Instance\Models;

use Flashpoint\Fuel\Models\Model;

class Airport extends Model
{
    protected $fillable = [
        'code',
        'name',
        'virtual',
        'child_airports'
    ];
}

<?php

namespace Flashpoint\Instance\Models;

use Flashpoint\Fuel\Models\Model;

class Flight extends Model
{
    public static $airlines = [
        'GR' => 'Aurigny',
        'BE' => 'Flybe',
        'BA' => 'British Airways'
    ];

    protected $fillable = [
        'airline',
        'flight_number',
        'origin',
        'destination'
    ];

    public function origin()
    {
        return $this->hasOne(Airport::class);
    }

    public function destination()
    {
        return $this->hasOne(Airport::class);
    }
}

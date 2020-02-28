<?php

use Flashpoint\Fuel\Routing;
use Flashpoint\Instance\Entities;
use Flashpoint\Instance\Models;
use Flashpoint\Instance\Observers;

return [
    Routing::bind('flights')
        ->withEntity(Entities\FlightsEntity::class)
        ->withModel(Models\Flight::class)
        ->includeObserver(Observers\FlightObserver::class),
    Routing::bind('airports')
        ->withEntity(Entities\AirportsEntity::class)
        ->withModel(Models\Airport::class)
        ->includeObserver(Observers\AirportObserver::class)
];

<?php

namespace Flashpoint\Instance\Observers;

use Flashpoint\Fuel\Observer;

class FlightObserver extends Observer
{
    public function whenUpdatedAirline()
    {
        if($this->state->has('other_airline') && $this->state->get('airline') != 'OTHER') {
            $this->state->del('other_airline');
        }
    }
}

<?php

namespace Flashpoint\Instance\Observers;

use Flashpoint\Fuel\Observer;

class AirportObserver extends Observer
{
    public function whenUpdatedIsVirtual()
    {
        if($this->state->has('child_airports') && !$this->state->get('is_virtual', false)) {
            $this->state->del('child_airports');
        }
    }
}

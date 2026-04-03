<?php

namespace App\Listeners;

use App\Events\VacateHouseTenant;
use App\HouseTenant;
use App\House;

class UpdateHouseVacated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VacateHouseTenant  $event
     * @return void
     */
    public function handle(VacateHouseTenant $event)
    {
        $house = House::findOrFail($event->house_id);
        $house->is_occupied = false;
        $house->rent_period = $house->rent_const;
        $house->save();

    }
}

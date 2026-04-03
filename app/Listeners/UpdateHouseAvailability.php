<?php

namespace App\Listeners;

use App\Events\NewHouseTenant;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\HouseTenant;
use App\House;

class UpdateHouseAvailability
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
     * @param  NewHouseTenant  $event
     * @return void
     */
    public function handle(NewHouseTenant $event)
    {
        $house=House::findOrFail($event->house_id);
        $house->is_occupied=true;
        $house->save();
    }
}

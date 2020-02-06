<?php

namespace App\Observers;

use App\Models\Device;
use App\Models\Activity;

class DeviceObserver
{
    /**
     * Handle the device "saved" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function saved(Device $device)
    {
        event(new \App\Events\DeviceEvent($device));   
    }

    /**
     * Handle the device "updated" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function updated(Device $device)
    {
        //
    }

    /**
     * Handle the device "deleted" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function deleted(Device $device)
    {
        //
    }

    /**
     * Handle the device "restored" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function restored(Device $device)
    {
        //
    }

    /**
     * Handle the device "force deleted" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function forceDeleted(Device $device)
    {
        //
    }
}

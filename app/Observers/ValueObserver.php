<?php

namespace App\Observers;

use App\Models\Value;

class ValueObserver
{
    /**
     * Handle the value "saved" event.
     *
     * @param  \App\Models\Value  $value
     * @return void
     */
    public function saved(Value $value)
    {
        event(new \App\Events\ValueEvent($value));
    }

    /**
     * Handle the value "updated" event.
     *
     * @param  \App\Models\Value  $value
     * @return void
     */
    public function updated(Value $value)
    {
        //
    }

    /**
     * Handle the value "deleted" event.
     *
     * @param  \App\Models\Value  $value
     * @return void
     */
    public function deleted(Value $value)
    {
        //
    }

    /**
     * Handle the value "restored" event.
     *
     * @param  \App\Models\Value  $value
     * @return void
     */
    public function restored(Value $value)
    {
        //
    }

    /**
     * Handle the value "force deleted" event.
     *
     * @param  \App\Models\Value  $value
     * @return void
     */
    public function forceDeleted(Value $value)
    {
        //
    }
}

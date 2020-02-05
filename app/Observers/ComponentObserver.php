<?php

namespace App\Observers;

use App\Models\Component;

class ComponentObserver
{
    /**
     * Handle the component "saved" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function saved(Component $component)
    {
        $component->avg = ($component->values->avg('value') ? number_format($component->values->avg('value'),1):0);
        
        event(new \App\Events\ComponentEvent($component));
    }

    /**
     * Handle the component "updated" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function updated(Component $component)
    {
        //
    }

    /**
     * Handle the component "deleted" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function deleted(Component $component)
    {
        //
    }

    /**
     * Handle the component "restored" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function restored(Component $component)
    {
        //
    }

    /**
     * Handle the component "force deleted" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function forceDeleted(Component $component)
    {
        //
    }
}

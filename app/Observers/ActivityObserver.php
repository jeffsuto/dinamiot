<?php

namespace App\Observers;

use App\models\Activity;

class ActivityObserver
{
    /**
     * Handle the activity "saved" event.
     *
     * @param  \App\models\Activity  $activity
     * @return void
     */
    public function saved(Activity $activity)
    {
        if ($activity->status == "new") {
            event(new \App\Events\ActivityEvent($activity));
        }
    }

    /**
     * Handle the activity "updated" event.
     *
     * @param  \App\models\Activity  $activity
     * @return void
     */
    public function updated(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "deleted" event.
     *
     * @param  \App\models\Activity  $activity
     * @return void
     */
    public function deleted(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "restored" event.
     *
     * @param  \App\models\Activity  $activity
     * @return void
     */
    public function restored(Activity $activity)
    {
        //
    }

    /**
     * Handle the activity "force deleted" event.
     *
     * @param  \App\models\Activity  $activity
     * @return void
     */
    public function forceDeleted(Activity $activity)
    {
        //
    }
}

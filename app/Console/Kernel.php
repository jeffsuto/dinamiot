<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

use App\Models\Device;
use App\Models\Activity;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // check if device is disconnected
        $schedule->call(function(){
            $devices = Device::where('state', 1)->get();
            
            foreach ($devices as $device) {
                $last_active = $device->last_active_date;
                $timeout = $device->endpoint->request_interval + 15;
                $datetime_now = Carbon::now();

                if ($last_active->addSeconds($timeout)->lt($datetime_now)) {
                    $device->state = 0;
                    $device->save();

                    // create activity
                    $activity = new Activity;
                    $activity->type = "danger";
                    $activity->title = "$device->name is disconnected!";
                    $activity->color = "red";
                    $activity->icon = "icon-drive";
                    $activity->status = "new";
                    $activity->message = "Your device: $device->name is disconnected from the server";
                    $activity->link = route('web.devices.show', $device->id);
                    $activity->save();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Run the check:cycles command every minute for testing (or adjust as needed)
        $schedule->command('check:cycles')->daily();
        //daily(), hourly everyMinute
         // Schedule the check:end_dates command to run daily
         $schedule->command('check:end_dates')->daily();
         $schedule->command('check:end_hours')->daily();
         $schedule->call('\App\Http\Controllers\NotificationsController@sendUserReport')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }

    /**
     * Register the commands for the application.
     */
 /*   protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }*/
}

<?php

namespace App\Console;

use App\Console\Commands\SendEmailVerificationReminderCommand;
use App\Console\Commands\SendNewsLetterCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNewsLetterCommand::class,
        SendEmailVerificationReminderCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->evenInMaintenanceMode()->sendOutputTo(storage_path('logs/inspired.log'))->hourly();
        // $schedule->call(function ()
        // {
        //     echo "HOLA";
        // })->everyMinute();
        // $schedule->command(SendNewsLetterCommand::class)
        //     ->withoutOverlapping()
        //     ->onOneServer()
        //     ->everyMinute();
        // $schedule->command(SendEmailVerificationReminderCommand::class)
        //     ->withoutOverlapping()
        //     ->onOneServer()
        //     ->everyMinute();
        $schedule->call(function ()
        {
            logger("HOLA desde el SCHEDULER");
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

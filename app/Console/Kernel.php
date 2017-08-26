<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ModuleCommand::class,
        \App\Console\Commands\RoiCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            \Artisan::call('roi');
        })->dailyAt('00:00');

        // $schedule->command(\App\Console\Commands\BonusPassive::class)->everyMinute()->withoutOverlapping();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}


































}    }        require base_path('routes/console.php');        $this->load(__DIR__.'/Commands');    {    protected function commands()     */     * @return void     *     * Register the commands for the application.    /**    }        $schedule->command('equipment:reset')->dailyAt('18:00');        // ...existing schedules...    {    protected function schedule(Schedule $schedule)     */     * @return void     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule     *     * Define the application's command schedule.    /**{class Kernel extends ConsoleKerneluse Illuminate\Foundation\Console\Kernel as ConsoleKernel;use Illuminate\Console\Scheduling\Schedule;namespace App\Console;<?php
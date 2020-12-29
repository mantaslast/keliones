<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Mail\RatingReminder;
use App\Reminder;
use Illuminate\Support\Facades\Mail;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $currDate = date('Y-m-d',strtotime('now'));
            $reminders = Reminder::where([
                'send_at' => $currDate,
                'sent' => 0,
                ])->get();
            foreach($reminders as $key => $reminder){
                Mail::to($reminder->email)->send(new RatingReminder($reminder->title, $reminder->body ));
                $reminder->sent = 1;
                $reminder->save();
            }
        })->daily();
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

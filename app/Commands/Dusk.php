<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Dusk extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'dusk';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'try dusk';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->browse(function ($browser) {
            $browser
                ->resize(1280, 1280) // Width and Height
                ->visit("https://datastudio.google.com/reporting/b22871d8-f2e0-4b2a-ad6a-78bb207ff8d3/page/VSfBB")
                ->pause(10000)
                ->click('Close')
                ->screenshot('ll-marketshare');
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}

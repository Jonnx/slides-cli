<?php

namespace App\Commands\Auth;

use App\Actions\Google\Auth\GetAuthorizedGoogleClient;
use App\Actions\Google\Auth\GetLoginLink;
use App\Actions\Google\Auth\GetTokenFromCode;
use App\Actions\Google\Auth\GetUserInfo;
use App\Actions\Storage\MakeStorageFolder;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Cache;

class GoogleMe extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'google:me';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'show authorized google account';

    protected $accessToken;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userInfo = GetUserInfo::run();

        $this->table(
            ['Name', 'Email', 'Email Verified?'],
            [[$userInfo->name, $userInfo->email, $userInfo->verifiedEmail ? 'Yes' : 'No']]
        );
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

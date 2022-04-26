<?php

namespace App\Commands\Auth;

use App\Actions\Google\Auth\GetLoginLink;
use App\Actions\Google\Auth\GetTokenFromCode;
use App\Actions\Storage\MakeStorageFolder;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Cache;

class GoogleLogin extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'google:login';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'authenticate slides-cli to use your google account';

    protected $accessToken;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // OPEN GOOGLE AUTHENTICATION FLOW IN BROWSER
        $this->task('Launching Google Authentication', function () {
            $loginLink = GetLoginLink::run();
            exec('open "' . $loginLink . '"');
            return true;
        });

        // CATPURE GOOGLE TOKEN
        $code = $this->ask('Paste your Google authorization code');

        // EXCHANGE TOKEN FOR ACCESS TOKEN
        $accessToken = null;
        $this->task('Exchanging code for access token', function () use ($code, $accessToken) {
            $this->accessToken = GetTokenFromCode::run($code);
            return $this->accessToken !== null;
        });

        if ($this->accessToken) {
            // SAVE TOKEN IN CACHE FOR LATER USE
            $this->task('Saving access token to cache', function () {
                MakeStorageFolder::run();
                return Cache::put('google.access_token', $this->accessToken['access_token']);
            });
        }
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

<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Yaml\Yaml;

class ImagesFetch extends Command
{
    protected $yaml;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'images:fetch {url}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'download a series of images from yaml file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');

        // parse config file
        $this->task('Fetching Images in [' . $url . ']', function () use ($url) {
            try {
                $this->yaml = Yaml::parseFile($url);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        foreach ($this->yaml as $folder => $images) {
            $this->info($folder . ':');

            $this->task("ensure directory [{$folder}] exists", function () use ($folder) {
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
            });

            foreach ($images as $name => $url) {
                $this->task("Fetching [{$name}]", function () use ($folder, $name, $url) {
                    try {
                        $storagePath = "./{$folder}/{$name}";
                        file_put_contents($storagePath, file_get_contents($url));
                        return true;
                    } catch (\Exception $e) {
                        return false;
                    }
                });
            }
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

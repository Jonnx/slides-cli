<?php

namespace App\Commands\GoogleSlides;

use App\Actions\Google\Slides\CreatePresentation;
use App\Actions\Google\Slides\CreatePresentationSlides;
use App\Actions\Google\Slides\GetCreateSlideRequest;
use App\Actions\Google\Slides\GetPresentationLink;
use App\Actions\Yaml\GetJsonFromFile;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class PresentationCreate extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'presentation:create {url}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'generate a presentation from a standard format';

    protected $yaml = null;
    protected $presentation = null;
    protected $slideRequests = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->task('Loading presentation definition', function () {
            $this->yaml = GetJsonFromFile::run($this->argument('url'));
            return true;
        });

        $this->task('Create presentation', function () {
            $presentationTitle = data_get(array_keys($this->yaml), 0);
            $this->presentation = CreatePresentation::run($presentationTitle);
        });

        $this->task('Extract slides definition', function () {
            foreach (array_values($this->yaml)[0]['slides'] as $slideDefinition) {
                $requests = GetCreateSlideRequest::run($slideDefinition);
                foreach ($requests as $request) {
                    $this->slideRequests[] = $request;
                }
            }
        });

        $this->task('Adding slides to presentation', function () {
            CreatePresentationSlides::run($this->presentation, $this->slideRequests);
        });

        $this->line('');
        $this->info('Success');
        $this->line('The presentation has been generated.');
        $this->line('');

        $this->task('Opening presentation in default browser', function () {
            sleep(5);
            exec('open ' . GetPresentationLink::run($this->presentation));
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

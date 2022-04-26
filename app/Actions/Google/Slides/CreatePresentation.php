<?php

namespace App\Actions\Google\Slides;

use App\Actions\Google\Auth\GetAuthorizedGoogleClient;
use Lorisleiva\Actions\Concerns\AsAction;
use Google\Service\Slides;
use Illuminate\Support\Carbon;

class CreatePresentation
{
    use AsAction;

    public function handle($title)
    {
        $googleClient = GetAuthorizedGoogleClient::run();
        $slidesService = new Slides($googleClient);

        $presentation = new \Google_Service_Slides_Presentation(array(
            'title' => Carbon::now()->format('Y-m-d') . ' ' . $title,
        ));

        return $slidesService->presentations->create($presentation);
    }
}

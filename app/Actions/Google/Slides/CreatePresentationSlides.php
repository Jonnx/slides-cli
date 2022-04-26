<?php

namespace App\Actions\Google\Slides;

use App\Actions\Google\Auth\GetAuthorizedGoogleClient;
use Lorisleiva\Actions\Concerns\AsAction;
use Google\Service\Slides;

class CreatePresentationSlides
{
    use AsAction;

    public function handle($presentation, $requests)
    {
        $googleClient = GetAuthorizedGoogleClient::run();
        $slidesService = new Slides($googleClient);

        $batchUpdateRequest = new \Google_Service_Slides_BatchUpdatePresentationRequest([
            'requests' => $requests
        ]);

        return $slidesService->presentations->batchUpdate($presentation->presentationId, $batchUpdateRequest);
    }
}

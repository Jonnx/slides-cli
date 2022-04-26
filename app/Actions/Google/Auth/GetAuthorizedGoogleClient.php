<?php

namespace App\Actions\Google\Auth;

use Lorisleiva\Actions\Concerns\AsAction;
use \Google\Client as GoogleClient;

class GetAuthorizedGoogleClient
{
    use AsAction;

    public function handle()
    {
        $accessToken = GetAccessToken::run();
        $googleClient = app(GoogleClient::class);
        $googleClient->setAccessToken($accessToken);
        return $googleClient;
    }
}

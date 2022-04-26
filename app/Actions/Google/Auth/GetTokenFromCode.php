<?php

namespace App\Actions\Google\Auth;

use Lorisleiva\Actions\Concerns\AsAction;
use \Google\Client as GoogleClient;

class GetTokenFromCode
{
    use AsAction;

    public function handle($code)
    {
        try {
            $googleClient = app(GoogleClient::class);
            $googleClient->authenticate($code);
            return $googleClient->getAccessToken();
        } catch (\Exception $e) {
            // @todo Implement this
        }
    }
}

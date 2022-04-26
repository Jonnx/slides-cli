<?php

namespace App\Actions\Google\Auth;

use Lorisleiva\Actions\Concerns\AsAction;
use \Google\Client as GoogleClient;

class GetLoginLink
{
    use AsAction;

    public function handle()
    {
        $googleClient = app(GoogleClient::class);
        return $googleClient->createAuthUrl();
    }
}

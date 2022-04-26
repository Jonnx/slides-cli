<?php

namespace App\Actions\Google\Auth;

use Lorisleiva\Actions\Concerns\AsAction;
use \Google\Client as GoogleClient;

class GetUserInfo
{
    use AsAction;

    public function handle()
    {
        $googleClient = GetAuthorizedGoogleClient::run();
        $googleClient = GetAuthorizedGoogleClient::run();
        $oauth2 = new \Google_Service_Oauth2($googleClient);
        return $oauth2->userinfo->get();
    }
}

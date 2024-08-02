<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Google\Service\Slides;

class AppServiceProvider extends ServiceProvider
{
    public const GOOGLE_SCOPES = [
        Oauth2::USERINFO_PROFILE,
        Oauth2::USERINFO_EMAIL,
        Slides::DRIVE_FILE,
    ];
    public const GOOGLE_REDIRECT = 'https://clioauth.com';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleClient::class, function () {
            $googleClient = new GoogleClient();
            $googleClient->setAuthConfig([
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            ]);
            foreach (self::GOOGLE_SCOPES as $scope) {
                $googleClient->addScope($scope);
            }
            $googleClient->setRedirectUri(self::GOOGLE_REDIRECT);
            return $googleClient;
        });
    }
}

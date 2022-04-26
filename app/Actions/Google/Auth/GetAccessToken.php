<?php

namespace App\Actions\Google\Auth;

use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAccessToken
{
    use AsAction;

    public function handle()
    {
        return Cache::get('google.access_token');
    }
}

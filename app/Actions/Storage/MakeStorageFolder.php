<?php

namespace App\Actions\Storage;

use Lorisleiva\Actions\Concerns\AsAction;

class MakeStorageFolder
{
    use AsAction;

    public function handle()
    {
        $user = null;
        exec('whoami', $user);

        @exec("mkdir /Users/{$user}/.slides-cli > /dev/null 2>&1");
        @exec("mkdir /Users/{$user}/.slides-cli/storage > /dev/null 2>&1");
        @exec("mkdir /Users/{$user}/.slides-cli/storage/files > /dev/null 2>&1");
        @exec("mkdir /Users/{$user}/.slides-cli/storage/cache > /dev/null 2>&1");
        return true;
    }
}

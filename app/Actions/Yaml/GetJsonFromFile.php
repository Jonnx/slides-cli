<?php

namespace App\Actions\Yaml;

use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\Yaml\Yaml;

class GetJsonFromFile
{
    use AsAction;

    public function handle($url)
    {
        return Yaml::parseFile($url);
    }
}

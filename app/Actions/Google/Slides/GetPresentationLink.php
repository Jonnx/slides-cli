<?php

namespace App\Actions\Google\Slides;

use Lorisleiva\Actions\Concerns\AsAction;

class GetPresentationLink
{
    use AsAction;

    public function handle($presentation)
    {
        $presentationId = $presentation->presentationId;
        return "https://docs.google.com/presentation/d/{$presentationId}/edit";
    }
}

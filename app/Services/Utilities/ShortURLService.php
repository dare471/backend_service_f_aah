<?php

namespace App\Services\Utilities;
use AshAllenDesign\ShortURL\Facades\ShortURL;

class ShortURLService
{
    public function createShortURL(string $destinationUrl): string
    {
        $shortURLObject = ShortURL::destinationUrl($destinationUrl)->make();
        return $shortURLObject->default_short_url;
    }
}

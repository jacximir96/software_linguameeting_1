<?php

namespace App\Src\Shared\Model\ValueObject;

use App\Src\Shared\Exception\UrlInvalid;

class Url
{
    private string $url;

    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UrlInvalid();
        }

        $this->url = $url;
    }

    public function get(): string
    {
        return $this->url;
    }
}

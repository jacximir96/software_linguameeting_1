<?php

namespace App\Src\Shared\Model\ValueObject;

use App\Src\Shared\Exception\UrlInvalid;

class HtmlLink
{
    private string $url;

    private string $text;

    private string $title = '';

    private function __construct(string $url, string $text, string $title = '')
    {
        $this->url = $url;
        $this->text = $text;
        $this->title = $title;
    }

    public static function create(string $url, string $text, string $title = ''): self
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new UrlInvalid();
        }

        return new static($url, $text, $title);
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function title(): string
    {
        return $this->title;
    }
}

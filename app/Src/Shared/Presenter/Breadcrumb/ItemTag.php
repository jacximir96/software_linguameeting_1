<?php

namespace App\Src\Shared\Presenter\Breadcrumb;

class ItemTag implements Item
{
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function write(): string
    {
        return $this->tag;
    }

    public function isLink(): bool
    {
        return false;
    }
}

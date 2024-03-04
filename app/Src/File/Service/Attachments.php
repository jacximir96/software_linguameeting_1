<?php

namespace App\Src\File\Service;

use Illuminate\Support\Collection;

class Attachments
{
    private Collection $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function get(): Collection
    {
        return $this->items;
    }

    public function push(Attachment $attachment)
    {
        $this->items->push($attachment);
    }
}

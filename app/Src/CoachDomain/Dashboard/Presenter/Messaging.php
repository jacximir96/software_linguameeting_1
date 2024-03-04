<?php

namespace App\Src\CoachDomain\Dashboard\Presenter;

use Illuminate\Support\Collection;

class Messaging
{
    private Collection $messages;

    private int $total;

    public function __construct(Collection $messages, int $total)
    {
        $this->messages = $messages;
        $this->total = $total;
    }

    public function get(): Collection
    {
        return $this->messages;
    }

    public function total(): int
    {
        return $this->total;
    }
}

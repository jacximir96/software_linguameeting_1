<?php

namespace App\Src\CoachDomain\Dashboard\Presenter;

use Illuminate\Support\Collection;

class Notifications
{
    private Collection $notifications;

    private int $total;

    public function __construct(Collection $notifications, int $total)
    {

        $this->notifications = $notifications;
        $this->total = $total;
    }

    public function get(): Collection
    {
        return $this->notifications;
    }

    public function total(): int
    {
        return $this->total;
    }
}

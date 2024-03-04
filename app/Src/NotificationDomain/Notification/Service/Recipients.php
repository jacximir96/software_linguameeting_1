<?php

namespace App\Src\NotificationDomain\Notification\Service;

use Illuminate\Support\Collection;

class Recipients
{
    private Collection $recipientsIds;

    public function __construct()
    {
        $this->recipientsIds = collect();
    }

    public function get(): Collection
    {
        return $this->recipientsIds;
    }

    public function add(int $userId)
    {
        $this->recipientsIds->put($userId, $userId);
    }
}

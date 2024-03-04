<?php

namespace App\Src\UserDomain\Status\Model;

class ActiveStatus implements Status
{
    public function id(): int
    {
        return config('linguameeting.user.status.enabled');
    }

    public function write(): string
    {
        return 'Active';
    }

    public function isActivate(): bool
    {
        return true;
    }

    public function isDisabled(): bool
    {
        return false;
    }

    public function isBlocked(): bool
    {
        return false;
    }

    public function isDeleted(): bool
    {
        return false;
    }
}

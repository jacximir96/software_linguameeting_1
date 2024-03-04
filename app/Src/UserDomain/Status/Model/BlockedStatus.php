<?php

namespace App\Src\UserDomain\Status\Model;

class BlockedStatus implements Status
{
    public function id(): int
    {
        return config('linguameeting.user.status.blocked');
    }

    public function write(): string
    {
        return 'Blocked';
    }

    public function isActivate(): bool
    {
        return false;
    }

    public function isDisabled(): bool
    {
        return false;
    }

    public function isBlocked(): bool
    {
        return true;
    }

    public function isDeleted(): bool
    {
        return false;
    }
}

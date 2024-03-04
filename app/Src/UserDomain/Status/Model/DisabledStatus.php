<?php

namespace App\Src\UserDomain\Status\Model;

class DisabledStatus implements Status
{
    public function id(): int
    {
        return config('linguameeting.user.status.disabled');
    }

    public function write(): string
    {
        return 'Disabled';
    }

    public function isActivate(): bool
    {
        return false;
    }

    public function isDisabled(): bool
    {
        return true;
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

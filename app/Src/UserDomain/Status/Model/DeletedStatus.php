<?php

namespace App\Src\UserDomain\Status\Model;

class DeletedStatus implements Status
{
    public function id(): int
    {
        return config('linguameeting.user.status.deleted');
    }

    public function write(): string
    {
        return 'Deleted';
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
        return false;
    }

    public function isDeleted(): bool
    {
        return true;
    }
}

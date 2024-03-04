<?php

namespace App\Src\UserDomain\Status\Service;

use App\Src\UserDomain\Status\Exception\StatusNotFound;
use App\Src\UserDomain\Status\Model\ActiveStatus;
use App\Src\UserDomain\Status\Model\BlockedStatus;
use App\Src\UserDomain\Status\Model\DeletedStatus;
use App\Src\UserDomain\Status\Model\DisabledStatus;
use App\Src\UserDomain\Status\Model\Status;
use App\Src\UserDomain\User\Model\User;

class StatusFactory
{
    const ID_ENABLED = 1;

    const ID_DISABLED = 2;

    const ID_BLOCKED = 3;

    const ID_DELETED = 4;

    public function buildFromId(int $status): Status
    {

        return match ($status) {
            self::ID_ENABLED => new ActiveStatus(),
            self::ID_DISABLED => new DisabledStatus(),
            self::ID_BLOCKED => new BlockedStatus(),
            self::ID_DELETED => new DeletedStatus(),
        };
    }

    public function buildFromUser(User $user): Status
    {

        if ($user->isDeleted()) {
            return new DeletedStatus();
        } elseif ($user->isDisabled()) {
            return new DisabledStatus();
        } elseif ($user->isLocked()) {
            return new BlockedStatus();
        } elseif ($user->isActive()) {
            return new ActiveStatus();
        }

        throw new StatusNotFound();
    }
}

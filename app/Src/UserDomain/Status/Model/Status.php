<?php

namespace App\Src\UserDomain\Status\Model;

interface Status
{
    public function id(): int;

    public function write(): string;

    public function isActivate(): bool;

    public function isDisabled(): bool;

    public function isBlocked(): bool;

    public function isDeleted(): bool;
}

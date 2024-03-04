<?php

namespace App\Src\CourseDomain\Course\Service\Status;

class ActiveStatus implements Status
{
    const SLUG = 'active';

    public function isActive(): bool
    {
        return true;
    }

    public function isPast(): bool
    {
        return false;
    }

    public function isDraft(): bool
    {
        return false;
    }

    public function name(): string
    {
        return 'Active';
    }

    public function slug(): string
    {
        return self::SLUG;
    }
}

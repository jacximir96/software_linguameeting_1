<?php

namespace App\Src\CourseDomain\Course\Service\Status;

class PastStatus implements Status
{
    const SLUG = 'past';

    public function isActive(): bool
    {
        return false;
    }

    public function isPast(): bool
    {
        return true;
    }

    public function isDraft(): bool
    {
        return false;
    }

    public function name(): string
    {
        return 'Past';
    }

    public function slug(): string
    {
        return self::SLUG;
    }
}

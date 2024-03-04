<?php

namespace App\Src\CourseDomain\Course\Service\Status;

class DraftStatus implements Status
{
    const SLUG = 'draft';

    public function isActive(): bool
    {
        return false;
    }

    public function isPast(): bool
    {
        return false;
    }

    public function isDraft(): bool
    {
        return true;
    }

    public function name(): string
    {
        return 'Draft';
    }

    public function slug(): string
    {
        return self::SLUG;
    }
}

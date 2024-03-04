<?php

namespace App\Src\CourseDomain\Course\Service\Status;

interface Status
{
    public function isActive(): bool;

    public function isPast(): bool;

    public function isDraft(): bool;

    public function name(): string;

    public function slug(): string;
}

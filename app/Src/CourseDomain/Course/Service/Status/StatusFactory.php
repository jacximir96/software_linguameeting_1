<?php

namespace App\Src\CourseDomain\Course\Service\Status;

class StatusFactory
{
    public function buildBySlug(string $slug): Status
    {
        return match ($slug) {
            ActiveStatus::SLUG => new ActiveStatus(),
            DraftStatus::SLUG => new DraftStatus(),
            PastStatus::SLUG => new PastStatus(),
        };
    }

    public function buildActiveStatus(): ActiveStatus
    {
        return new ActiveStatus();
    }
}

<?php

namespace App\Src\CourseDomain\Assignment\Service;

class StatusAssignment
{
    private int $totalSessions;

    private int $completed;

    public function __construct(int $totalSessions, int $completed)
    {

        $this->totalSessions = $totalSessions;
        $this->completed = $completed;
    }

    public function totalSessions(): int
    {
        return $this->totalSessions;
    }

    public function completed(): int
    {
        return $this->completed;
    }

    public function left(): int
    {
        return $this->totalSessions - $this->completed;
    }

    public function isCompleted(): bool
    {
        return $this->completed >= $this->totalSessions;
    }
}

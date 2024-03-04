<?php

namespace App\Src\StudentDomain\Calendar\Presenter;

class CalendarSetup
{
    private string $viewType;

    private int $minutes;

    public function __construct(string $viewType, int $minutes = 15)
    {

        $this->viewType = $viewType;
        $this->minutes = $minutes;
    }

    public function minutes(): int
    {
        return $this->minutes;
    }

    public function viewType(): string
    {
        return $this->viewType;
    }

    public function isListDay(): bool
    {
        return $this->viewType == 'listDay';
    }
}

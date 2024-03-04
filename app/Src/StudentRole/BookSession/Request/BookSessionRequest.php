<?php

namespace App\Src\StudentRole\BookSession\Request;

interface BookSessionRequest
{
    public function hasCoachId(): bool;

    public function coachId(): int|string;

    public function filterByTimeHour(): bool;
}

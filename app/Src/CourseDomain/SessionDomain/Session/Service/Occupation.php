<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;

class Occupation
{
    private int $currentRegistered;

    private int $totalAllowed;

    public function __construct(int $currentRegistered, int $totalAllowed)
    {

        $this->currentRegistered = $currentRegistered;
        $this->totalAllowed = $totalAllowed;
    }

    public function currentRegistered(): int
    {
        return $this->currentRegistered;
    }

    public function totalAllowed(): int
    {
        return $this->totalAllowed;
    }

    public function isFull(): bool
    {
        return $this->currentRegistered == $this->totalAllowed;
    }

    public function isEmpty():bool{
        return $this->currentRegistered === 0;
    }
}

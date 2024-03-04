<?php

namespace App\Src\CourseDomain\Flex\Service;


use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriod;

class FlexSession implements SessionOrderPeriod
{
    private int $sessionNumber;

    public function __construct(int $sessionNumber)
    {

        $this->sessionNumber = $sessionNumber;
    }

    public function number(): int
    {
        return $this->sessionNumber;
    }

    public function sessionOrderObject():SessionOrder{
        return new SessionOrder($this->sessionNumber);
    }

    public function isSame(int $otherNumber): bool
    {
        return $this->sessionNumber == $otherNumber;
    }

    public function hasPeriod(): bool
    {
        return false;
    }

    public function writeSessionNumber(): string
    {
        return 'Session '.$this->sessionNumber;
    }
}

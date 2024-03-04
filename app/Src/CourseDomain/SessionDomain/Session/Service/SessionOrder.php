<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;

class SessionOrder
{
    private int $order;

    public function __construct(int $order)
    {

        if ($order < 1) {
            throw new \InvalidArgumentException(sprintf('Session order %s is invalid', $order));
        }

        $this->order = $order;
    }

    public function get(): int
    {
        return $this->order;
    }

    public function isSame(SessionOrder $otherOrder):bool{
        return $this->order == $otherOrder->get();
    }

    public function isSameOrder(int $value):bool{
        return $this->order == $value;
    }
}

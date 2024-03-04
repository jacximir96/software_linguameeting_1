<?php

namespace App\Src\Shared\Model\ValueObject;

class Id
{
    private int $id;

    public function __construct(int $id)
    {

        if ($id < 1) {
            throw new \Exception('Id must be greather than 0');
        }

        $this->id = $id;
    }

    public function get(): int
    {
        return $this->id;
    }
}

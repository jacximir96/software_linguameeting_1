<?php

namespace App\Src\CourseDomain\Course\Service\Status;

class StatusLingro
{
    private bool $hasLingro;

    private bool $hasNotLingro;

    public function __construct(bool $hasLingro, bool $hasNotLingro)
    {
        $this->hasLingro = $hasLingro;
        $this->hasNotLingro = $hasNotLingro;
    }

    public function hasLingro(): bool
    {
        return $this->hasLingro;
    }

    public function hasNotLingro(): bool
    {
        return $this->hasNotLingro;
    }

    public function hasBoth(): bool
    {
        return $this->hasLingro and $this->hasNotLingro;
    }
}

<?php

namespace App\Src\Shared\Model;

interface Morpheable
{
    public function morphType(): string;
}

<?php

namespace App\Src\CourseDomain\Section\Service;

class SectionCode
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function get(): string
    {
        return $this->code;
    }
}

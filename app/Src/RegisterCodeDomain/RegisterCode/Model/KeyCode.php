<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Model;

class KeyCode
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

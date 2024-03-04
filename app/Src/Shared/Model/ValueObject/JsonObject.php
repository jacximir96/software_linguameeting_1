<?php

namespace App\Src\Shared\Model\ValueObject;

class JsonObject
{
    private array $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function createFromArray(array $data): self
    {
        return new static($data);
    }

    public function get(): string
    {
        return json_encode($this->data);
    }
}

<?php
namespace App\Src\Shared\Service;


class Order
{

    private string $field;

    private string $type;

    public function __construct (string $field, string $type = 'asc'){

        $this->field = $field;
        $this->type = $type;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function type(): string
    {
        return $this->type;
    }
}

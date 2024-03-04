<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer;


class Value
{
    private string $field;
    private string $value;

    public function __construct(string $field, string $value){

        $this->field = $field;
        $this->value = $value;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function value(): string
    {
        return $this->value;
    }
}

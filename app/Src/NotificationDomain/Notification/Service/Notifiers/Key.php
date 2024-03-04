<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers;


class Key
{

    private string $value;

    public function __construct(string $value){

        $this->value = $value;
    }

    public function get(): string
    {
        return $this->value;
    }
}

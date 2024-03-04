<?php
namespace App\Src\NotificationDomain\Notification\Service\DataExtra;


class DataExtraIdItem implements DataExtraItem
{
    private string $key;
    private string $id;


    public function __construct (string $key, string $id){
        $this->key = $key;
        $this->id = $id;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): array
    {
        return [
            'id' => $this->id
        ];
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'values' => [
                'id' => $this->id,
            ]
        ];
    }
}

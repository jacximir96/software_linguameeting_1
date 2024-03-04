<?php
namespace App\Src\NotificationDomain\Notification\Service\DataExtra;


class DataExtraChangeItem implements DataExtraItem
{
    private string $key;
    private string $before;
    private string $after;

    public function __construct (string $key, string $before, string $after){
        $this->key = $key;
        $this->before = $before;
        $this->after = $after;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): array
    {
        return [
            'before' => $this->before,
            'after' => $this->after,
        ];
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'values' => $this->value()
        ];
    }
}

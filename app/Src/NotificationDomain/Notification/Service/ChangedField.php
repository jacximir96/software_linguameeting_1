<?php
namespace App\Src\NotificationDomain\Notification\Service;


use App\Src\NotificationDomain\Notification\Service\DataExtra\DataExtraChangeItem;

class ChangedField
{
    private string $field;
    private string $before;
    private string $after;

    public function __construct (string $field, string $before, string $after){

        $this->field = $field;
        $this->before = $before;
        $this->after = $after;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getBefore(): string
    {
        return $this->before;
    }

    public function getAfter(): string
    {
        return $this->after;
    }

    public function convertToDataExtraItem ():DataExtraChangeItem{

        return new DataExtraChangeItem($this->field, $this->before, $this->after);

    }
}

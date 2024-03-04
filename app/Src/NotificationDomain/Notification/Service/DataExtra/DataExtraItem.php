<?php
namespace App\Src\NotificationDomain\Notification\Service\DataExtra;


interface DataExtraItem
{

    public function key():string;

    public function value():array;

    public function toArray():array;

}

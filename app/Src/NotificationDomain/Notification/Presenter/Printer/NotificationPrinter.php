<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer;

use Illuminate\Support\Collection;

interface NotificationPrinter
{
    public function key():string;

    public function before():Collection;

    public function after():Collection;
}

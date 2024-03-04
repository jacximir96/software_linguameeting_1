<?php
namespace App\Src\ActivityLog\Service\Activities;

use Carbon\Carbon;


trait Printable
{

    public function createdAt ():Carbon{
        return $this->activity->created_at;
    }

    public function description(): string
    {
        return trans('log.'.$this->description);
    }
}

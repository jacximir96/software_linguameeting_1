<?php

namespace App\Src\StudentDomain\Makeup\Action\Command;

use App\Src\StudentDomain\Makeup\Model\Makeup;

class DeleteMakeupCommand
{
    public function handle(Makeup $makeup): Makeup
    {

        $makeup->delete();

        return $makeup;
    }
}

<?php

namespace App\Src\StudentDomain\ExtraSession\Action\Command;

use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;

class DeleteExtraSessionCommand
{
    public function handle(ExtraSession $extraSession): ExtraSession
    {

        $extraSession->delete();

        return $extraSession;
    }
}

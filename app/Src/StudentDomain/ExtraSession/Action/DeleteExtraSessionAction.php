<?php

namespace App\Src\StudentDomain\ExtraSession\Action;

use App\Src\StudentDomain\ExtraSession\Action\Command\DeleteExtraSessionCommand;
use App\Src\StudentDomain\ExtraSession\Exception\ExtraSessionHasBeenUsed;
use App\Src\StudentDomain\ExtraSession\Model\ExtraSession;

class DeleteExtraSessionAction
{
    private DeleteExtraSessionCommand $deleteExtraSessionCommand;

    public function __construct(DeleteExtraSessionCommand $deleteExtraSessionCommand)
    {

        $this->deleteExtraSessionCommand = $deleteExtraSessionCommand;
    }

    public function handle(ExtraSession $extraSession): ExtraSession
    {

        if ($extraSession->hasBeenUsed()) {
            throw new ExtraSessionHasBeenUsed();
        }

        return $this->deleteExtraSessionCommand->handle($extraSession);
    }
}

<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action;

use App\Src\CourseDomain\SessionDomain\Session\Action\Command\DeleteSessionCommand;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

class DeleteSessionAction
{
    private DeleteSessionCommand $deleteSessionCommand;

    public function __construct(DeleteSessionCommand $deleteSessionCommand)
    {

        $this->deleteSessionCommand = $deleteSessionCommand;
    }

    public function handle(Session $session): Session
    {

        if ($session->coachSessionStatus->isNotCelebrated()) {

            $this->deleteSessionCommand->handle($session);

            return $session;
        }

        return $session;

    }
}

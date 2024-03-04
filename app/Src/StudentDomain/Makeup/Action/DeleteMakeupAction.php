<?php

namespace App\Src\StudentDomain\Makeup\Action;

use App\Src\StudentDomain\Makeup\Action\Command\DeleteMakeupCommand;
use App\Src\StudentDomain\Makeup\Exception\MakeupHasBeenUsed;
use App\Src\StudentDomain\Makeup\Model\Makeup;

class DeleteMakeupAction
{
    private DeleteMakeupCommand $deleteMakeupCommand;

    public function __construct(DeleteMakeupCommand $deleteMakeupCommand)
    {

        $this->deleteMakeupCommand = $deleteMakeupCommand;
    }

    public function handle(Makeup $makeup): Makeup
    {

        if ($makeup->hasBeenUsed()) {
            throw new MakeupHasBeenUsed();
        }

        return $this->deleteMakeupCommand->handle($makeup);

    }
}

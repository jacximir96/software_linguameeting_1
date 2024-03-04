<?php

namespace App\Src\ExperienceDomain\ExperienceFile\Action;

use App\Src\ExperienceDomain\ExperienceFile\Action\Command\DeleteFileCommand;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;

class DeleteExperienceFileAction
{
    private DeleteFileCommand $deleteFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
    }

    public function handle(ExperienceFile $experienceFile)
    {
        $this->deleteFileCommand->handle($experienceFile);
    }
}

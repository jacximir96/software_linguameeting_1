<?php

namespace App\Src\ExperienceDomain\ExperienceFile\Action\Command;

use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;

class DeleteFileCommand
{
    public function handle(ExperienceFile $file)
    {
        $file->delete();
    }
}

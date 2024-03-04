<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Action;

use App\Src\ConversationGuideDomain\GuideFile\Action\Command\DeleteFileCommand;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;

class DeleteGuideFileAction
{
    private DeleteFileCommand $deleteFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
    }

    public function handle(ConversationGuideFile $file): ConversationGuideFile
    {

        $this->deleteFileCommand->handle($file);

        return $file;
    }
}

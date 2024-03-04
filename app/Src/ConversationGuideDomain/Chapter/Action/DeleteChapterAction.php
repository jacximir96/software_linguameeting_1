<?php

namespace App\Src\ConversationGuideDomain\Chapter\Action;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\ChapterFile\Action\Command\DeleteFileCommand;

class DeleteChapterAction
{
    private DeleteFileCommand $deleteFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
    }

    public function handle(Chapter $chapter): Chapter
    {

        if ($chapter->file) {
            $this->deleteFileCommand->handle($chapter->file);
        }

        $chapter->delete();

        return $chapter;
    }
}

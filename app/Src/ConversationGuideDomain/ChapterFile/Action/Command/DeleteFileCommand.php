<?php

namespace App\Src\ConversationGuideDomain\ChapterFile\Action\Command;

use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;

class DeleteFileCommand
{
    public function handle(GuideChapterFile $guideChapterFile)
    {
        $guideChapterFile->delete();
    }
}

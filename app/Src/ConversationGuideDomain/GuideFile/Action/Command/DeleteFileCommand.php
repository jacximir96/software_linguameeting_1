<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Action\Command;

use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;

class DeleteFileCommand
{
    public function handle(ConversationGuideFile $file)
    {
        $file->delete();
    }
}

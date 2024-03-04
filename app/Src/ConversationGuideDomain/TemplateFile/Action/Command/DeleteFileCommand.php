<?php

namespace App\Src\ConversationGuideDomain\TemplateFile\Action\Command;

use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;

class DeleteFileCommand
{
    public function handle(TemplateFile $file)
    {
        $file->delete();
    }
}

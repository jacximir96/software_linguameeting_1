<?php

namespace App\Src\ConversationGuideDomain\Template\Action;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\TemplateFile\Action\Command\DeleteFileCommand;

class DeleteTemplateAction
{
    private DeleteFileCommand $deleteFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
    }

    public function handle(Template $template): Template
    {

        if ($template->file) {
            $this->deleteFileCommand->handle($template->file);
        }

        $template->delete();

        return $template;
    }
}

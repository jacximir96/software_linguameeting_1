<?php

namespace App\Src\ConversationGuideDomain\Template\Action;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\Template\Request\TemplateRequest;
use App\Src\ConversationGuideDomain\TemplateFile\Action\Command\DeleteFileCommand;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use App\Src\File\Command\UploadLocalFileCommand;

class UpdateTemplateAction
{
    private DeleteFileCommand $deleteFileCommand;

    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand, UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(TemplateRequest $request, Template $template): Template
    {

        $template->description = $request->description;
        $template->save();

        $this->proccessFile($request, $template);

        return $template;
    }

    private function proccessFile(TemplateRequest $request, Template $template)
    {

        if ($request->hasFile('template_file')) {

            if ($template->file) {
                $this->deleteFileCommand->handle($template->file);
            }

            $templateFile = new TemplateFile();
            $templateFile->template_id = $template->id;

            $this->uploadLocalFileCommand->handle($request->template_file, $templateFile);
        }
    }
}

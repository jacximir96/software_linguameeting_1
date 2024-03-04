<?php

namespace App\Src\ConversationGuideDomain\Template\Action;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\Template\Request\TemplateRequest;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use App\Src\File\Command\UploadLocalFileCommand;

class CreateTemplateAction
{
    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(TemplateRequest $request): Template
    {
        $template = new Template();
        $template->description = $request->description;
        $template->save();

        $this->proccessFile($request, $template);

        return $template;
    }

    private function proccessFile(TemplateRequest $request, Template $template): TemplateFile
    {
        $templateFile = new TemplateFile();
        $templateFile->template_id = $template->id;

        return $this->uploadLocalFileCommand->handle($request->template_file, $templateFile);
    }
}

<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Action;

use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\GuideFile\Request\UpdateGuideFileRequest;
use App\Src\File\Command\UploadLocalFileCommand;

class UpdateGuideFileAction
{
    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(UpdateGuideFileRequest $request, ConversationGuideFile $file): ConversationGuideFile
    {

        $file->description = $request->description;
        $file->save();

        $this->proccessFile($request, $file);

        return $file;
    }

    private function proccessFile(UpdateGuideFileRequest $request, ConversationGuideFile $file): ConversationGuideFile
    {

        if ($request->hasFile('file')) {
            $file = $this->uploadLocalFileCommand->handle($request->file, $file);
        }

        return $file;
    }
}

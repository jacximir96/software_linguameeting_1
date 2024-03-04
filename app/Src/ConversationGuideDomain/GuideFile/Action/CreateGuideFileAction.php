<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Action;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\GuideFile\Request\GuideFileRequest;
use App\Src\File\Command\UploadLocalFileCommand;

class CreateGuideFileAction
{
    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(GuideFileRequest $request, ConversationGuide $guide): ConversationGuideFile
    {
        $chapterFile = new ConversationGuideFile();
        $chapterFile->conversation_guide_id = $guide->id;
        $chapterFile->description = $request->description;

        return $this->uploadLocalFileCommand->handle($request->file, $chapterFile);
    }
}

<?php

namespace App\Src\ConversationGuideDomain\Chapter\Action;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Chapter\Request\ChapterRequest;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\File\Command\UploadLocalFileCommand;

class CreateChapterAction
{
    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(ChapterRequest $request, ConversationGuide $guide): Chapter
    {
        $chapter = new Chapter();
        $chapter->conversation_guide_id = $guide->id;
        $chapter->name = $request->name;
        $chapter->save();

        $this->proccessFile($request, $chapter);

        return $chapter;
    }

    private function proccessFile(ChapterRequest $request, Chapter $chapter)
    {

        if ($request->hasFile('chapter_file')) {

            $chapterFile = new GuideChapterFile();
            $chapterFile->conversation_guide_chapter_id = $chapter->id;

            $this->uploadLocalFileCommand->handle($request->chapter_file, $chapterFile);
        }
    }
}

<?php

namespace App\Src\ConversationGuideDomain\Chapter\Action;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\ConversationGuideDomain\Chapter\Request\ChapterRequest;
use App\Src\ConversationGuideDomain\ChapterFile\Action\Command\DeleteFileCommand;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\File\Command\UploadLocalFileCommand;

class UpdateChapterAction
{
    private DeleteFileCommand $deleteFileCommand;

    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(DeleteFileCommand $deleteFileCommand, UploadLocalFileCommand $uploadLocalFileCommand)
    {

        $this->deleteFileCommand = $deleteFileCommand;
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(ChapterRequest $request, Chapter $chapter): Chapter
    {

        $chapter->name = $request->name;
        $chapter->save();

        $this->deleteFile($request, $chapter);

        $this->proccessFile($request, $chapter);

        return $chapter;
    }

    private function deleteFile(ChapterRequest $request, Chapter $chapter)
    {

        if ($request->has('delete_file')) {
            if ($chapter->file) {
                $this->deleteFileCommand->handle($chapter->file);
            }
        }
    }

    private function proccessFile(ChapterRequest $request, Chapter $chapter)
    {

        if ($request->hasFile('chapter_file')) {

            if ($chapter->file) {
                $this->deleteFileCommand->handle($chapter->file);
            }

            $chapterFile = new GuideChapterFile();
            $chapterFile->conversation_guide_chapter_id = $chapter->id;

            $this->uploadLocalFileCommand->handle($request->chapter_file, $chapterFile);
        }
    }
}

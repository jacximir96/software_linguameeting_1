<?php

namespace App\Src\File\Service;

use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use App\Src\ConversationGuideDomain\ChapterFile\Model\GuideChapterFile;
use App\Src\ConversationGuideDomain\GuideFile\Model\ConversationGuideFile;
use App\Src\ConversationGuideDomain\TemplateFile\Model\TemplateFile;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\File\BookstoreRequestFile\Model\BookstoreRequestFile;
use App\Src\HelpDomain\IssueFile\Model\IssueFile;
use App\Src\MessagingDomain\File\Model\MessageFile;
use App\Src\UserDomain\ProfileImage\Model\ProfileImage;

class PathBuilder
{
    public function buildAssetUrl(string $key, string $filename): Path
    {

        $folderKey = config('linguameeting.files.folder.'.$key);

        $path = 'storage/'.$folderKey.'/'.$filename;

        return match ($key) {
            IssueFile::KEY_PATH => new Path(asset($path)),
            ProfileImage::KEY_PATH => new Path(asset($path)),
            ExperienceFile::KEY_PATH => new Path(asset($path)),
        };
    }

    //for get folder/file
    public function buildPublicAbsolutePath(string $key): Path
    {
        return match ($key) {
            AssignmentFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(AssignmentFile::KEY_PATH),
            BookstoreRequestFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(BookstoreRequestFile::KEY_PATH),
            ConversationGuideFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(ConversationGuideFile::KEY_PATH),
            ExperienceFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(ExperienceFile::KEY_PATH),
            GuideChapterFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(GuideChapterFile::KEY_PATH),
            IssueFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(IssueFile::KEY_PATH),
            ManagerEvaluationFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(ManagerEvaluationFile::KEY_PATH),
            MessageFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(MessageFile::KEY_PATH),
            ProfileImage::KEY_PATH => $this->buildPublicAbsolutePathFromKey(ProfileImage::KEY_PATH),
            Section::KEY_PATH_INSTRUCTIONS => $this->buildPublicAbsolutePathFromKey(Section::KEY_PATH_INSTRUCTIONS),
            TemplateFile::KEY_PATH => $this->buildPublicAbsolutePathFromKey(TemplateFile::KEY_PATH),
        };
    }

    //for save file
    public function buildStorageAbsolutePath(string $key): Path
    {
        return $this->buildStorageAbsolutePathFromKeyWithinPublic($key);

        /*
        return match ($key) {
            AssignmentFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(AssignmentFile::KEY_PATH),
            BookstoreRequestFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(BookstoreRequestFile::KEY_PATH),
            CoachEvaluationManagerFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(CoachEvaluationManagerFile::KEY_PATH),
            ExperienceFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(ExperienceFile::KEY_PATH),
            GuideChapterFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(GuideChapterFile::KEY_PATH),
            ConversationGuideFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(ConversationGuideFile::KEY_PATH),
            Section::KEY_PATH_INSTRUCTIONS => $this->buildStorageAbsolutePathFromKeyWithinPublic(Section::KEY_PATH_INSTRUCTIONS),
            ProfileImage::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(ProfileImage::KEY_PATH),
            TemplateFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(TemplateFile::KEY_PATH),
            ThreadFile::KEY_PATH => $this->buildStorageAbsolutePathFromKeyWithinPublic(ThreadFile::KEY_PATH),

            'attachments' => $this->buildStorageAbsolutePathFromKeyWithinPublic('attachments'),
        };
        */
    }

    public function buildStoragePath(string $key): Path
    {

        return match ($key) {
            'attachments' => $this->buildStorageAbsolutePathFromKey('attachments'),
        };
    }

    public function buildAbsoluteFilePath(string $folderKey, string $filename): File
    {
        $path = $this->buildPublicAbsolutePath($folderKey);

        return $path->buildFile($filename);
    }

    private function buildPublicAbsolutePathFromKey(string $folderKey): Path
    {
        $folderKey = config('linguameeting.files.folder.'.$folderKey);

        //public_path('storage..') => /var/www/html/linguameetingv2/storage/app/public
        return new Path(public_path('storage/'.$folderKey));
    }

    private function buildStorageAbsolutePathFromKeyWithinPublic(string $folderKey): Path
    {
        $folderKey = config('linguameeting.files.folder.'.$folderKey);

        return new Path(storage_path('app/public/'.$folderKey));
    }

    private function buildStorageAbsolutePathFromKey(string $folderKey): Path
    {

        $folderKey = config('linguameeting.files.folder.'.$folderKey);

        return new Path(storage_path('app/'.$folderKey));
    }
}

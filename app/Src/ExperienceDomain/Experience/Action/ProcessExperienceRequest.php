<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\ExperienceRequest;
use App\Src\ExperienceDomain\Experience\Service\ExperienceFiles;
use App\Src\ExperienceDomain\ExperienceFile\Action\Command\DeleteFileCommand;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFileType;
use App\Src\File\Command\UploadLocalFileCommand;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use Carbon\Carbon;

class ProcessExperienceRequest
{
    private LinguaMoney $linguaMoney;

    private ExperienceFiles $experienceFiles;

    private UploadLocalFileCommand $uploadLocalFileCommand;

    private DeleteFileCommand $deleteFileCommand;

    public function __construct(LinguaMoney $linguaMoney, UploadLocalFileCommand $uploadLocalFileCommand, DeleteFileCommand $deleteFileCommand)
    {

        $this->linguaMoney = $linguaMoney;
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
        $this->deleteFileCommand = $deleteFileCommand;
    }

    public function handle(ExperienceRequest $request, Experience $experience): Experience
    {

        $this->experienceFiles = $experience->files();

        $experience->title = $request->title;
        $experience->description = $request->description;

        $experience->start = Carbon::parse($request->day.' '.$request->start_time, config('linguameeting.timezone.by_default_in_experiences'))->setTimezone('UTC');
        $experience->end = Carbon::parse($request->day.' '.$request->end_time, config('linguameeting.timezone.by_default_in_experiences'))->setTimezone('UTC');

        $experience->language_id = $request->language_id;
        $experience->level_id = $request->level_id;
        $experience->code_offer_type_id = $request->code_offer_type_id;
        $experience->university_id = $request->university_id;
        $experience->course_id = $request->course_id;
        $experience->url_join = $request->url_join;

        $experience->is_private = $request->is_private;
        $experience->is_paid_private = $request->is_paid_private;
        $experience->is_donate_private = $request->is_donate_private;
        $experience->is_public = $request->is_public;
        $experience->is_paid_public = $request->is_paid_public;
        $experience->is_donate_public = $request->is_donate_public;

        $experience->max_students = $request->max_students;

        $experience->price = null;
        if ($request->filled('price')) {
            $experience->price = $this->linguaMoney->buildFromFloat($request->price);
        }

        $experience->coach_id = $request->coach_id;
        $experience->coach_name = $request->coach_name ?? '';
        $experience->coach_lastname = $request->coach_lastname ?? '';

        $experience->save();

        $this->updateVocabularyFile($request, $experience);

        $this->updateBannerFile($request, $experience, 1);

        $this->updateBannerFile($request, $experience, 2);

        return $experience;

    }

    private function updateVocabularyFile(ExperienceRequest $request, Experience $experience)
    {

        if ($request->hasFile('vocabulary_file')) {

            if ($this->experienceFiles->hasVocabularyFile()) {
                $this->deleteFileCommand->handle($this->experienceFiles->vocabularyFile());
            }

            $vocabularyFile = new ExperienceFile();
            $vocabularyFile->experience_id = $experience->id;
            $vocabularyFile->experience_file_type_id = ExperienceFileType::ID_VOCABULARY;
            $vocabularyFile->order = 1; //solo tiene un archivo de vocabulario

            $this->uploadLocalFileCommand->handle($request->vocabulary_file, $vocabularyFile);
        }
    }

    private function updateBannerFile(ExperienceRequest $request, Experience $experience, int $order)
    {

        $fieldFile = 'banner_'.$order;
        if ($request->hasFile($fieldFile)) {

            if ($this->experienceFiles->hasBannerFile($order)) {
                $this->deleteFileCommand->handle($this->experienceFiles->bannerFile($order));
            }

            $vocabularyFile = new ExperienceFile();
            $vocabularyFile->experience_id = $experience->id;
            $vocabularyFile->experience_file_type_id = ExperienceFileType::ID_BANNER;
            $vocabularyFile->order = $order;

            $this->uploadLocalFileCommand->handle($request->$fieldFile, $vocabularyFile);
        }
    }
}

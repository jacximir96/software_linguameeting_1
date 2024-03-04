<?php

namespace App\Src\ExperienceDomain\Experience\Service;

use App\Src\ExperienceDomain\ExperienceFile\Exception\FileTypeWrong;
use App\Src\ExperienceDomain\ExperienceFile\Model\ExperienceFile;
use Illuminate\Support\Collection;

class ExperienceFiles
{
    private ?ExperienceFile $vocabularyFile = null;

    private Collection $bannersFiles;

    public function __construct()
    {

        $this->vocabularyFile = null;
        $this->bannersFiles = collect();
    }

    public function hasVocabularyFile(): bool
    {
        return ! is_null($this->vocabularyFile);
    }

    public function vocabularyFile(): ExperienceFile
    {
        return $this->vocabularyFile;
    }

    public function hasBannerFile(int $order)
    {

        foreach ($this->bannersFiles as $file) {
            if ($file->isOrder($order)) {
                return true;
            }
        }

        return false;
    }

    public function bannerFile(int $order): ExperienceFile
    {
        foreach ($this->bannersFiles as $file) {
            if ($file->isOrder($order)) {
                return $file;
            }
        }
    }

    public function add(ExperienceFile $file)
    {

        if ($file->type->isVocabulary()) {
            $this->vocabularyFile = $file;
        } else {
            $this->bannersFiles->push($file);
        }
    }

    public function addVocabularyFile(ExperienceFile $vocabularyFile)
    {

        if (! $vocabularyFile->type->isVocabulary()) {
            throw new FileTypeWrong();
        }

        $this->vocabularyFile = $vocabularyFile;
    }

    public function addBannerFile(ExperienceFile $bannerFile)
    {

        if (! $bannerFile->type->isBanner()) {
            throw new FileTypeWrong();
        }

        $this->bannersFiles->push($bannerFile);
    }
}

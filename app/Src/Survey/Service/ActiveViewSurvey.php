<?php
namespace App\Src\Survey\Service;

use App\Src\Shared\Model\ValueObject\Url;
use App\Src\Survey\Model\Survey;


class ActiveViewSurvey implements ViewSurvey
{
    private Survey $survey;

    public function __construct (Survey $survey){
        $this->survey = $survey;
    }

    public function isDefault(): bool
    {
        return false;
    }

    public function description(): string
    {
        return $this->survey->description;
    }

    public function url(): Url
    {
        return new Url($this->survey->url);
    }

    public function survey(): Survey
    {
        return $this->survey;
    }
}

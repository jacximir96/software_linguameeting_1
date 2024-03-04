<?php
namespace App\Src\Survey\Service;

use App\Src\Shared\Model\ValueObject\Url;

class DefaultViewSurvey implements ViewSurvey
{

    public function isDefault(): bool
    {
        return true;
    }

    public function description(): string
    {
        return config('linguameeting.survey.default.description');
    }

    public function url(): Url
    {
        return new Url(config('linguameeting.survey.default.url'));
    }
}

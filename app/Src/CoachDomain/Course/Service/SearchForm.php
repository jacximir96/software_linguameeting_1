<?php

namespace App\Src\CoachDomain\Course\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\Shared\Service\FormSearchUniversityCourse;

class SearchForm extends BaseSearchForm
{
    use FormSearchUniversityCourse;

    const KEY_FORM = 'coach_course_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $universitiesOptions;

    private array $courseOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function statusOptions(): array
    {
        return $this->statusOptions;
    }

    public function config()
    {
        $this->action = route('post.coach.course.search');

        $this->configModelForm(self::KEY_FORM);

        $this->universitiesOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->fillCourseOptions();
    }
}

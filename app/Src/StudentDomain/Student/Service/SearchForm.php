<?php

namespace App\Src\StudentDomain\Student\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'student_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $universitiesOptions;

    private array $courseOptions;

    private array $statusOptions;

    private array $lingroOptions;

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
        $this->action = route('post.admin.student.search');

        $this->configCustomModelForm();

        $this->universitiesOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->statusOptions = $this->fieldFormBuilder->obtainStatusUserOptions();

        $this->lingroOptions = $this->fieldFormBuilder->obtainBooleanOptions();

        $this->fillCourseOptions();
    }

    private function configCustomModelForm(): void
    {
        $statusId = null;
        if (request()->has('status')) {
            $statusId = request()->status;
        }

        if ($statusId) {
            $this->configModelForm(self::KEY_FORM, ['status' => $statusId]);
        } else {
            $this->configModelForm(self::KEY_FORM);
        }
    }

    private function fillCourseOptions()
    {

        if (! $this->modelHasUniversitySelected()) {

            $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptions();

            return;
        }

        $universityIds = [];
        $model = $this->model();

        foreach ($model['university_id'] as $universityId) {
            if ($universityId) {
                $universityIds[] = $universityId;
            }
        }

        $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptionsFromUniversities($universityIds);

    }

    private function modelHasUniversitySelected(): bool
    {

        $model = $this->model();

        if (! isset($model['university_id'])) {
            return false;
        }

        if (is_array($model['university_id'])) {

            foreach ($model['university_id'] as $universityId) {
                if ($universityId) {
                    return true;
                }
            }
        }

        return false;
    }
}

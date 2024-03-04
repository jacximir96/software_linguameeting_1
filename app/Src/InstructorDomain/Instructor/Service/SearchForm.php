<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'instructor_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private array $universityOptions;

    private array $courseOptions;

    private array $languageOptions;

    private array $roleOptions;

    private array $statusOptions;

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
        $this->action = route('post.admin.instructor.search');

        $this->configCustomModelForm();

        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->roleOptions = $this->fieldFormBuilder->obtainInstructorRoleOptions();

        $this->statusOptions = $this->fieldFormBuilder->obtainStatusUserOptions();

        $this->fillCourseOptions();

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
}

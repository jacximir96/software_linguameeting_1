<?php

namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Service\Status\ActiveStatus;
use App\Src\CourseDomain\Course\Service\Status\Status;
use App\Src\CourseDomain\Course\Service\Status\StatusFactory;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class SearchForm extends BaseSearchForm
{
    const KEY_FORM = 'course_searcher';

    private FieldFormBuilder $fieldFormBuilder;

    private StatusFactory $statusFactory;

    private array $languageOptions;

    private array $levelOptions;

    private array $semesterOptions;

    private array $universityOptions;

    private array $statusOptions;

    private array $lingroOptions;

    private array $serviceTypeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder, StatusFactory $statusFactory)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->statusFactory = $statusFactory;
    }

    public function fieldWithOptions(string $field): array
    {
        return $this->$field;
    }

    public function status(): Status
    {
        if (isset($this->model['status'])) {
            return $this->statusFactory->buildBySlug($this->model['status']);
        }

        return $this->statusFactory->buildActiveStatus();
    }

    public function config()
    {

        $this->initialize();

        $this->action = route('post.admin.course.search');

        $defaultConfig = $this->obtainDefaultConfig();

        $this->configModelForm(self::KEY_FORM, $defaultConfig);

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->levelOptions = $this->fieldFormBuilder->obtainUniversityLevelOptions();

        $this->semesterOptions = $this->fieldFormBuilder->obtainSemesterOptions();

        $this->universityOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->statusOptions = $this->fieldFormBuilder->obtainStatusCourseOptions();

        $this->lingroOptions = $this->fieldFormBuilder->obtainBooleanOptions();

        $this->serviceTypeOptions = $this->fieldFormBuilder->obtainServiceTypeOptions();
    }

    private function initialize()
    {

        $this->languageOptions = [];
        $this->levelOptions = [];
        $this->semesterOptions = [];
        $this->universityOptions = [];
        $this->statusOptions = [];
        $this->lingroOptions = [];
        $this->serviceTypeOptions = [];
    }

    private function obtainDefaultConfig(): array
    {
        $defaultConfig = [];

        $statusExistsInRequest = request()->has('status');
        $isFormInSession = session()->has($this->buildKeyForm(self::KEY_FORM));

        if (! $statusExistsInRequest and ! $isFormInSession) {
            $defaultConfig['status'] = $this->statusFactory->buildBySlug(ActiveStatus::SLUG)->slug();
        }

        return $defaultConfig;
    }
}

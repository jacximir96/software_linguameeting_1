<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UniversityDomain\University\Model\University;
use Carbon\Carbon;

class AcademicDatesForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $semesterOptions = [];

    private array $yearsOptions = [];

    private array $languageOptions = [];

    private array $experienceTypeOptions = [];

    private LinguaMoney $linguaMoney;

    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate(University $university)
    {
        $this->action = route('post.admin.course.coaching_form_experiences.create.academic_dates', $university->id);

        $this->configCommon();

        $this->model = [];
    }

    public function configForUpdate(Course $course)
    {

        $this->action = route('post.admin.course.coaching_form_experiences.create.update.academic_dates', $course->id);

        $this->configCommon();

        $this->model = $course->toArray();

        $this->model['start_date'] = $course->start_date->toDateString();
        $this->model['end_date'] = $course->end_date->toDateString();

        if ($course->hasDiscount()) {
            $this->model['discount'] = $this->linguaMoney->formatForFormField($course->discount);
        }
    }

    private function configCommon()
    {

        $this->semesterOptions = $this->fieldFormBuilder->obtainSemesterOptions();

        $this->yearsOptions = $this->fieldFormBuilder->obtainNumberOptions(Carbon::now()->year, Carbon::now()->year + 1);

        $this->languageOptions = $this->fieldFormBuilder->obtainOneLanguageOption(Language::SPANISH_ID);

        $this->experienceTypeOptions = $this->fieldFormBuilder->obtainExperiencesTypeOptions();
    }
}

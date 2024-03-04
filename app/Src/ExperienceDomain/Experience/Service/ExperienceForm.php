<?php

namespace App\Src\ExperienceDomain\Experience\Service;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class ExperienceForm extends BaseSearchForm
{
    //construct
    private FieldFormBuilder $fieldFormBuilder;

    private LinguaMoney $linguaMoney;


    //status
    private array $codeOfferOptions;

    private array $coachOptions;

    private array $languageOptions;

    private array $universityOptions;

    private array $courseOptions;

    private array $levelOptions;


    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.experience.create');

        $this->model = [];
        $this->model['is_private'] = true;
        $this->model['is_donate_private'] = true;
        $this->model['is_paid_public'] = true;
        $this->model['max_students'] = 50;

        $this->configCommonOptions();
    }

    public function configToEdit(Experience $experience)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.experience.edit', $experience);

        $this->model = $experience->toArray();

        $start = $experience->start->setTimezone(config('linguameeting.timezone.by_default_in_experiences'));
        $end = $experience->end->setTimezone(config('linguameeting.timezone.by_default_in_experiences'));

        $this->model['day'] = $start->toDateString();
        $this->model['start_time'] = $start->format('H:i');
        $this->model['end_time'] = $end->format('H:i');

        if ($experience->hasPrice()) {
            $this->model['price'] = $this->linguaMoney->formatForFormField($experience->price);
        }

        $this->configCommonOptions();

        if ($experience->assignedToUniversityOrCourse() ){
            $this->courseOptions = $this->fieldFormBuilder->obtainCourseOptionsFromUniversities([$experience->university_id]);
        }
    }

    private function configCommonOptions()
    {
        $this->codeOfferOptions = $this->fieldFormBuilder->obtainCodeOfferExperienceOptions();

        $this->coachOptions = $this->fieldFormBuilder->obtainCoachesOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->levelOptions = $this->fieldFormBuilder->obtainExperienceLevelOptions();

        $this->courseOptions = [];

        $this->universityOptions = [];
    }
}

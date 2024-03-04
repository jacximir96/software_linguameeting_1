<?php

namespace App\Src\UserDomain\User\Service;

use App\Src\CoachDomain\Coach\Service\CoachableForm;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class EditCoachProfileForm extends BaseSearchForm
{
    use CoachableForm;

    const SLUG = 'profile_edit';

    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $languageOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $coach)
    {
        $this->isEdit = true;

        $this->action = route('post.coach.profile.edit');

        $this->configModel($coach);

        $this->configHobbies($coach);

        $this->configOptions();
    }

    private function configModel(User $coach)
    {

        $this->model = [];
        $this->model['active'] = true;

        $this->model = $coach->toArray();
        $this->model['language_id'] = $coach->language->first()->id;

        $this->model['country_id'] = $coach->country_id ?? null;
        $this->model['country_live_id'] = $coach->country_live_id ?? null;

        $this->model['language'] = $coach->language->pluck('id', 'id')->toArray();
        $this->model['role_id'] = $coach->roles()->first()->id;

        $this->model['zoom_email'] = $coach->zoomUser->zoom_email ?? null;

        $this->model['description'] = $coach->coachInfo->description;
        $this->model['url_video'] = $coach->coachInfo->url_video;
    }

    private function configOptions()
    {

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

    }

    private function configHobbies(User $coach)
    {

        if ($coach->hobby()->count()) {
            $this->configModelHobbies($coach);
        } else {
            $this->configModelNewHobbies();
        }
    }
}

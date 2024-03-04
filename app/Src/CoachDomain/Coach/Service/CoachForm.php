<?php

namespace App\Src\CoachDomain\Coach\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class CoachForm extends BaseSearchForm
{
    use CoachableForm;

    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

    private array $languageOptions;

    private array $levelOptions;

    private array $roleOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function countryOptions(): array
    {
        return $this->countryOptions;
    }

    public function timezoneOptions(): array
    {
        return $this->timezoneOptions;
    }

    public function languageOptions(): array
    {
        return $this->languageOptions;
    }

    public function levelOptions(): array
    {
        return $this->levelOptions;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.coach.create');

        $this->model = [];
        $this->model['active'] = true;

        $this->configCommonOptions();

        $this->configModelNewHobbies();
    }

    public function configToEdit(User $coach)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.update', $coach->hashId());

        $this->configModel($coach);

        $this->configModelHobbies($coach);

        $this->configCommonOptions();
    }

    private function configModel(User $coach)
    {
        $this->model = $coach->toArray();
        $this->model['password'] = '';
        $this->model['country_id'] = $coach->country_id ?? null;
        $this->model['country_live_id'] = $coach->country_live_id ?? null;

        $this->model['language'] = $coach->language->pluck('id', 'id')->toArray();
        $this->model['role_id'] = $coach->roles()->first()->id;

        $this->model['level_id'] = $coach->coachInfo->level_id ?? null;
        $this->model['is_trainee'] = $coach->coachInfo->is_trainee;
        $this->model['description'] = $coach->coachInfo->description;
        $this->model['url_video'] = $coach->coachInfo->url_video;

        $this->model['zoom_email'] = $coach->zoomUser->zoom_email ?? null;

        if ($coach->hasEmailVerified()){
            $this->model['email_verified'] = true;
        }
    }

    private function configCommonOptions()
    {
        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();

        $this->levelOptions = $this->fieldFormBuilder->obtainCoachLevelOptions();

        $this->roleOptions = $this->fieldFormBuilder->obtainCoachRoleOptions();
    }
}

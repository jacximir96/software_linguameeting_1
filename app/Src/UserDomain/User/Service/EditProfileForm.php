<?php

namespace App\Src\UserDomain\User\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class EditProfileForm extends BaseSearchForm
{
    const SLUG = 'profile_edit';

    private FieldFormBuilder $fieldFormBuilder;

    private array $countryOptions;

    private array $timezoneOptions;

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

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $user)
    {
        $this->action = route('post.user.profile.edit');

        $this->model = [];
        $this->model['active'] = true;

        $this->model = $user->toArray();

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->timezoneOptions = $this->fieldFormBuilder->obtainTimezonesOptions();
    }
}

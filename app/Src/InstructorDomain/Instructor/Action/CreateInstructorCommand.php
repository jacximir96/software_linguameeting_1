<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\BasicInstructorRequest;
use App\Src\Localization\Language\Model\Language;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CreateInstructorCommand
{
    private User $instructor;

    private PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function handle(BasicInstructorRequest $request, University $university, Language $language, Collection $roles): User
    {
        $this->createUser($request, $university);

        $this->assignLanguage($language);

        $this->assignCoordinatorRol($roles);

        return $this->instructor;
    }

    private function createUser(BasicInstructorRequest $request, University $university)
    {
        $this->instructor = new User;
        $this->instructor->password = $this->passwordService->generatePassword();

        $this->instructor->name = $request->name;
        $this->instructor->lastname = $request->lastname;
        $this->instructor->email = $request->email;
        $this->instructor->country_id = $university->country_id;
        $this->instructor->timezone_id = $university->timezone_id;
        $this->instructor->active = true;
        $this->instructor->internal_comment = $request->internal_comment ?? '';

        $this->instructor->save();
    }

    private function assignLanguage(Language $language)
    {
        $this->instructor->language()->sync($language);
    }

    private function assignCoordinatorRol(Collection $roles)
    {
        $this->instructor->assignRole($roles);
    }
}

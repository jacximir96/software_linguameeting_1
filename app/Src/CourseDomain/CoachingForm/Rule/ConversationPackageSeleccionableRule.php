<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use Illuminate\Contracts\Validation\Rule;

class ConversationPackageSeleccionableRule implements Rule
{
    private CourseInformationRequest $request;

    private ConversationPackageRepository $conversationPackageRepository;

    public function __construct(CourseInformationRequest $request, ConversationPackageRepository $conversationPackageRepository)
    {
        $this->request = $request;
        $this->conversationPackageRepository = $conversationPackageRepository;
    }

    public function passes($attribute, $value)
    {
        if (! $this->request->filled('session_type_id')) {
            return true;
        }

        if (! $this->request->filled('number_session')) {
            return true;
        }

        if (! $this->request->filled('duration_session')) {
            return true;
        }

        //solo validamos cuando tenmos los valores anteriores completos
        $sessionType = SessionType::find($this->request->session_type_id);

        $sessionSetup = SessionSetup::createWithInteger($this->request->number_session, $this->request->duration_session);

        $conversationPackage = $this->conversationPackageRepository->obtainForAssignToCourse($sessionType, $sessionSetup, $this->isWithExperience());

        if (is_null($conversationPackage)) {
            return false;
        }

        return true;
    }

    private function isWithExperience(): bool
    {
        if ($this->request->isCreateCourse()) {
            $factory = app(SessionWizardFactory::class);
            $wizard = $factory->buildFromSession();

            return $wizard->withExperience();
        }

        $course = $this->request->course;

        return $course->conversationPackage->hasExperiences();
    }

    public function message()
    {
        return trans('coaching_form.conversation_package_not_exists');
    }
}

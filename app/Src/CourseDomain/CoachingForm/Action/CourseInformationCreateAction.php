<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\WizardManager;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;

class CourseInformationCreateAction
{
    private WizardManager $wizardManager;

    private CourseCreateAction $createCourseAction;

    public function __construct(WizardManager $wizardManager, CourseCreateAction $createCourseAction)
    {
        $this->wizardManager = $wizardManager;
        $this->createCourseAction = $createCourseAction;
    }

    public function handle(CourseInformationRequest $request, User $user): Course
    {
        $wizard = $this->wizardManager->saveRequestInSession($request);

        return $this->createCourseAction->handle($wizard, $user);
    }
}

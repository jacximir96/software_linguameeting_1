<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\ConversationPackageDomain\Package\Exception\ConversationPackageNotFound;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\UserDomain\User\Model\User;

class CourseInformationUpdateAction
{
    private CourseInformationRequest $request;

    private Course $course;

    private SessionType $sessionType;

    private ConversationPackageRepository $conversationPackageRepository;

    private GuideRepository $guideRepository;

    private LinguaMoney $linguaMoney;

    public function __construct(ConversationPackageRepository $conversationPackageRepository, GuideRepository $guideRepository, LinguaMoney $linguaMoney)
    {
        $this->conversationPackageRepository = $conversationPackageRepository;
        $this->guideRepository = $guideRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function handle(CourseInformationRequest $request, Course $course, User $user): Course
    {
        $this->initialize($request, $course);

        $course->name = $request->name;

        $course->language_id = $request->language_id;

        $numberMakeups = $request->numberMakeups();
        $course->buy_makeups = (bool) $numberMakeups;
        $course->number_makeups = $numberMakeups;

        $course->is_lingro = $request->isUserLingro();

        if ($course->allowsFullEdition($user)) {
            $this->runFullUpdate($request, $course);
        }

        if ($user->hasAdminRoles()) {
            $this->runAdminUpdate($course, $request);
        }

        $courseChanges = new CourseChanges($course);
        event(new ChangeCourseEvent($user, $courseChanges));

        $course->save();

        return $course;
    }

    private function initialize(CourseInformationRequest $request, Course $course)
    {
        $this->request = $request;
        $this->course = $course;
    }

    private function runFullUpdate(CourseInformationRequest $request, Course $course): void
    {
        $this->sessionType = SessionType::find($request->session_type_id);

        $conversationPackage = $this->obtainConversationPackage();
        $conversationGuide = $this->obtainConversationGuideOrNull();

        $course->conversation_package_id = $conversationPackage->id;
        $course->conversation_guide_id = $conversationGuide->id;
    }

    private function obtainConversationPackage(): ConversationPackage
    {
        $sessionSetup = SessionSetup::createWithInteger($this->request->number_session, $this->request->duration_session);

        $withExperience = $this->request->isExperienceSelectedInPrevStep();

        $conversationPackage = $this->conversationPackageRepository->obtainForAssignToCourse($this->sessionType, $sessionSetup, $withExperience);

        if (is_null($conversationPackage)) {
            if ($this->sessionType->isSmallGroup() and $withExperience) {
                $userFeedback = trans('conversation_package.exception.small_group_without_experience');
            } else {
                $userFeedback = trans('conversation_package.exception.conversation_package_not_exists', [
                    'session_number' => $sessionSetup->sessionNumber()->get(),
                    'session_duration' => $sessionSetup->sessionDuration()->get(),
                ]);
            }

            throw new ConversationPackageNotFound($userFeedback);
        }

        return $conversationPackage;
    }

    private function obtainConversationGuideOrNull(): ?ConversationGuide
    {
        $guide = null;

        if ($this->request->isUserLingro()) {
            return ConversationGuide::find($this->request->guide_id);
        }

        $language = Language::find($this->request->language_id);

        return $this->guideRepository->obtainFromLinguameetingByLanguage($language);
    }

    private function runAdminUpdate(Course $course, CourseInformationRequest $request): void
    {
        $course->student_class = $this->request->student_class;
        $course->only_week_makeups = $this->request->only_week_makeups;

        $course->discount = null;
        if ($request->filled('discount')) {
            $course->discount = $this->linguaMoney->buildFromFloat($request->discount);
        }

        $course->is_free = $request->isFree();
        $course->complimentary_makeup = $request->complimentary_makeup;
    }
}

<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\ConversationPackageDomain\Package\Exception\ConversationPackageNotFound;
use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Wizard;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\CourseTerm;
use App\Src\CourseDomain\Course\Model\SessionSetup;
use App\Src\CourseDomain\Course\Model\StudentsNumber;
use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\CourseDomain\Holiday\Action\AssignHolidaysDatesToCourseAction;
use App\Src\CourseDomain\Holiday\Model\HolidaysDates;
use App\Src\CourseDomain\ServiceType\Model\ServiceType;
use App\Src\Localization\Language\Model\Language;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\ColorFactory;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CourseCreateAction
{
    private ConversationPackageRepository $conversationPackageRepository;

    private Wizard $wizard;

    private SessionType $sessionType;

    private GuideRepository $guideRepository;

    private LinguaMoney $linguaMoney;

    private ColorFactory $colorFactory;

    private AssignHolidaysDatesToCourseAction $assignHolidaysDatesToCourseAction;

    public function __construct(ConversationPackageRepository $conversationPackageRepository,
        GuideRepository $guideRepository,
        LinguaMoney $linguaMoney,
        ColorFactory $colorFactory, AssignHolidaysDatesToCourseAction $assignHolidaysDatesToCourseAction)
    {
        $this->conversationPackageRepository = $conversationPackageRepository;
        $this->guideRepository = $guideRepository;
        $this->linguaMoney = $linguaMoney;
        $this->colorFactory = $colorFactory;
        $this->assignHolidaysDatesToCourseAction = $assignHolidaysDatesToCourseAction;
    }

    public function handle(Wizard $wizard, User $user): Course
    {
        $this->initialize($wizard);

        $conversationPackage = $this->obtainConversationPackage();

        $courseTerm = $this->obtainCourseTerm();

        $conversationGuide = $this->obtainConversationGuideOrNull();

        $course = new Course();
        $course->university_id = $this->wizard->universityId();
        $course->language_id = $this->wizard->languageId();
        $course->conversation_package_id = $conversationPackage->id;
        $course->semester_id = $wizard->semesterId();
        $course->level_id = 3;
        $course->conversation_guide_id = $conversationGuide->id;
        $course->creator_id = $user->id;
        $course->name = $this->wizard->name();
        $course->student_class = $this->obtainStudentsBySession()->get();
        $course->duration = $this->wizard->durationSessions();
        $course->year = $this->wizard->year();
        $course->start_date = $courseTerm->startDate();
        $course->end_date = $courseTerm->endDate();

        $course->service_type_id = ServiceType::ID_CONVERSATIONS;
        if ($wizard->withExperience()) {
            $course->service_type_id = ServiceType::ID_COMBINED;
        }

        if ($wizard->hasDiscount()) {
            $course->discount = $this->linguaMoney->buildFromFloat($wizard->discount());
        }

        $numberMakeups = $wizard->numberMakeups();
        $course->buy_makeups = (bool) $numberMakeups;
        $course->number_makeups = $numberMakeups;

        $course->complimentary_makeup = $wizard->complimentaryMakeup();

        $course->is_lingro = $wizard->isLingro();
        $course->is_free = $wizard->isFree();
        $course->is_flex = false;

        $course->color = $this->colorFactory->generateColorRGBA();

        $course->save();

        $this->updateHolidays($course);

        $courseChanges = new CourseChanges($course);
        event(new ChangeCourseEvent($user, $courseChanges));

        return $course;
    }

    private function initialize(Wizard $wizard)
    {
        $this->wizard = $wizard;

        $this->sessionType = SessionType::find($wizard->conversationPackageTypeId());
    }

    private function obtainConversationPackage(): ConversationPackage
    {
        $sessionSetup = SessionSetup::createWithInteger($this->wizard->numSessions(), $this->wizard->durationSessions());

        $withExperience = $this->wizard->withExperience();

        $conversationPackage = $this->conversationPackageRepository->obtainForAssignToCourse($this->sessionType, $sessionSetup, $withExperience);

        if (is_null($conversationPackage)) {
            throw new ConversationPackageNotFound();
        }

        return $conversationPackage;
    }

    private function obtainStudentsBySession(): StudentsNumber
    {
        if ($this->wizard->hasStudentsSession()) {
            return StudentsNumber::create($this->wizard->studentsSession());
        }

        return $this->sessionType->defaultStudentsBySession();
    }

    private function obtainCourseTerm(): CourseTerm
    {
        $startDate = Carbon::parse($this->wizard->startDate());

        $endDate = Carbon::parse($this->wizard->endDate());

        return new CourseTerm($startDate, $endDate);
    }

    private function obtainConversationGuideOrNull(): ?ConversationGuide
    {
        $guide = null;

        if ($this->wizard->isLingro()) {
            return ConversationGuide::find($this->wizard->guideId());
        }

        $language = Language::find($this->wizard->languageId());

        if ($language->hasLinguameetingGuide()) {
            return $this->guideRepository->obtainFromLinguameetingByLanguage($language);
        }

        return null;
    }

    private function updateHolidays(Course $course)
    {
        $this->deleteCurrentHolidays($course);

        $this->assignHolidaysToCourse($course);
    }

    private function deleteCurrentHolidays(Course $course)
    {
        $course->holiday()->delete();
    }

    private function assignHolidaysToCourse(Course $course): void
    {

        $holidaysDates = new HolidaysDates();

        collect($this->wizard->holidays())->map(function ($date) use (&$holidaysDates) {
            $date = Carbon::parse($date);
            $holidaysDates->push($date);
        });

        $this->assignHolidaysDatesToCourseAction->handle($course, $holidaysDates);
    }
}

<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\CourseDomain\CoachingForm\Request\AcademicDatesRequest;
use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Service\CourseChanges;
use App\Src\CourseDomain\Holiday\Action\AssignHolidaysDatesToCourseAction;
use App\Src\CourseDomain\Holiday\Service\HolidaysChecker;
use App\Src\CourseDomain\Holiday\Model\HolidaysDates;
use App\Src\CourseDomain\Holiday\Service\HolidaysDifference;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class AcademicDatesUpdateAction
{
    private ConversationPackageRepository $conversationPackageRepository;

    private AssignHolidaysDatesToCourseAction $assignHolidayToCourseAction;

    private HolidaysChecker $holidaysChecker;


    public function __construct(ConversationPackageRepository $conversationPackageRepository,
                                AssignHolidaysDatesToCourseAction $assignHolidayToCourseAction,
                                HolidaysChecker $holidaysChecker)
    {
        $this->conversationPackageRepository = $conversationPackageRepository;
        $this->assignHolidayToCourseAction = $assignHolidayToCourseAction;
        $this->holidaysChecker = $holidaysChecker;
    }

    public function handle(AcademicDatesRequest $request, Course $course, User $user): Course
    {
        $course->semester_id = $request->semester_id;
        $course->year = $request->year;

        if ($course->allowsFullEdition($user)) {
            $course->start_date = Carbon::parse($request->start_date);
            $course->end_date = Carbon::parse($request->end_date);
        }

        $courseChanges = new CourseChanges($course);
        event(new ChangeCourseEvent($user, $courseChanges));

        $courseChanges = new CourseChanges($course);
        event(new ChangeCourseEvent($user, $courseChanges));

        $course->save();

        $this->updateHolidays($request, $course, $user);

        return $course;
    }

    private function updateHolidays(AcademicDatesRequest $request, Course $course, User $user)
    {
        $beforeHolidays = $course->holiday;


        $this->deleteCurrentHolidays($course);

        $this->assignHolidaysToCourse($request, $course);


        $afterHolidays = $course->fresh()->holiday;

        $difference = $this->obtainHolidaysDifference($beforeHolidays, $afterHolidays);

        if ($difference->thereAreDifferences()){
            $courseChanges = CourseChanges::buildWithHolidaysDifference($course, $difference);
            event(new ChangeCourseEvent($user, $courseChanges));
        }
    }

    private function deleteCurrentHolidays(Course $course)
    {
        $course->holiday()->delete();
    }

    private function assignHolidaysToCourse(AcademicDatesRequest $request, Course $course): void
    {
        $holidaysDates = new HolidaysDates();

        collect($request->holidays)->map(function ($date) use (&$holidaysDates) {
            $date = Carbon::parse($date);
            $holidaysDates->push($date);
        });

        $this->assignHolidayToCourseAction->handle($course, $holidaysDates);
    }

    private function obtainHolidaysDifference(Collection $beforeHolidays, Collection $afterHolidays):HolidaysDifference{
        return $this->holidaysChecker->obtainDifference($beforeHolidays, $afterHolidays);
    }
}

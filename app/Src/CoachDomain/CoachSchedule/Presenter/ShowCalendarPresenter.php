<?php

namespace App\Src\CoachDomain\CoachSchedule\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class ShowCalendarPresenter
{
    public function handle(User $coach): ShowCalendarResponse
    {

        $universities = $this->obtainCoursesByCoach($coach);

        return new ShowCalendarResponse($universities);
    }

    private function obtainCoursesByCoach(User $coach)
    {

        $courses = Course::query()
            ->with('university')
            ->where('end_date', '>=', Carbon::now()->addWeeks(2)->toDateString())
            ->whereHas('session', function ($query) use ($coach) {
                return $query->where('coach_id', $coach->id);
            })->get();

        $universities = collect();

        foreach ($courses as $course) {

            $universityId = $course->university->id;

            if (! $universities->has($universityId)) {
                $viewUniversity = new ViewUniversity($course->university);
                $universities->put($universityId, $viewUniversity);
            }

            $university = $universities->get($universityId);
            $university->addCourse($course);

        }

        return $universities;
    }
}

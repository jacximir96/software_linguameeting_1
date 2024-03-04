<?php

namespace App\Src\CourseDomain\CourseCoach\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoach\Model\CourseCoach;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\UserDomain\User\Model\User;

class CourseCoachRepository
{
    public function obtainByCourseAndCoachOrNull(Course $course, User $coach)
    {

        return CourseCoach::query()
            ->with($this->relation())
            ->where('course_id', $course->id)
            ->where('coach_id', $coach->id)
            ->first();
    }

    public function search(CriteriaSearch $criteriaSearch)
    {

        $query = CourseCoach::query()
            ->select('course_coach.*')
            ->with($this->relation())
            ->join('course', 'course_coach.course_id', '=', 'course.id')
            ->join('university', 'course.university_id', '=', 'university.id')
            ->where('coach_id', $criteriaSearch->get('coach_id'))
            ->whereHas('course', function ($query) {
                $query->active();
            });

        if ($criteriaSearch->searchBy('university_id')) {
            $query->whereHas('course.university', function ($query) use ($criteriaSearch) {
                return $query->whereIn('id', $criteriaSearch->get('university_id'));
            });
        }

        return $query->orderBy('university.name')
            ->orderBy('course.name')
            ->get();
    }

    public function relation(): array
    {

        return [
            'course',
            'course.university',
            'course.coachingWeek',
            'course.section',
        ];
    }
}

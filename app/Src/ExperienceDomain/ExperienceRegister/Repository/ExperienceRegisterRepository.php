<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;

class ExperienceRegisterRepository
{
    public function checkUserInExperience(Experience $experience, User $user)
    {

        return ExperienceRegister::query()
            ->where('experience_id', $experience->id)
            ->where('user_id', $user->id)
            ->exists();

    }

    public function obtainByExperienceAndUser(Experience $experience, User $user)
    {

        return ExperienceRegister::query()
            ->where('experience_id', $experience->id)
            ->where('user_id', $user->id)
            ->first();
    }

    public function obtainExperienceByEnrollment (Enrollment $enrollment){

        $period = $enrollment->course()->period();

        return ExperienceRegister::query()
            ->where('user_id', $enrollment->student_id)
            ->whereBetween('registered_at',  [$period->getStartDate(), $period->getEndDate()])
            ->orderBy('registered_at', 'desc')
            ->get();

    }

    public function obtainByExperience(Experience $experience)
    {

        return ExperienceRegister::query()
            ->select('experience_register.*')
            ->with('user')
            ->join('user', 'experience_register.user_id', '=', 'user.id')
            ->where('experience_id', $experience->id)

            ->orderBy('user.lastname', 'asc')
            ->orderBy('user.name', 'asc')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainByUser(User $student)
    {

        return ExperienceRegister::query()
            ->select('experience_register.*')
            ->with('experience')
            ->join('experience', 'experience_register.experience_id', '=', 'experience.id')
            ->where('user_id', $student->id)
            ->orderBy('experience.start', 'desc')
            ->get();

    }

    public function countRegisterByExperienceAndCourse(Experience $experience, Course $course){

        return ExperienceRegister::query()
            ->where('experience_id', $experience->id)
            ->wherehas('user.enrollment.section', function ($query) use($course){
                $query->where('course_id', $course->id);
            } )
            ->count();

    }

    public function countAttendedByExperienceAndCourse(Experience $experience, Course $course){

        return ExperienceRegister::query()
            ->where('experience_id', $experience->id)
            ->where('attendance', 1)
            ->wherehas('user.enrollment.section', function ($query) use($course){
                $query->where('course_id', $course->id);
            } )
            ->count();

    }

    public function registerByExperienceAndCourse(Experience $experience, Course $course){

        return ExperienceRegister::query()
            ->with('user', 'user.enrollment', 'user.enrollment.section', 'user.enrollment.section.course')
            ->where('experience_id', $experience->id)
            ->wherehas('user.enrollment.section', function ($query) use($course){
                $query->where('course_id', $course->id);
            } )
            ->get();

    }

    public function relations(): array
    {

        return [
            'experience',
            'user',
        ];

    }
}

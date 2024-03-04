<?php

namespace App\Src\CourseDomain\Section\Service;

use App\Src\CourseDomain\Course\Exception\CourseHasFinished;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Exception\SectionCodeNotExists;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\StudentDomain\Enrollment\Exception\AlreadyRegisteredInCourse;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class SectionCodeChecker
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {

        $this->sectionRepository = $sectionRepository;
    }

    public function checkCodeIsValidForStudentRegister(SectionCode $sectionCode): bool
    {

        $section = $this->sectionRepository->findByCode($sectionCode->get());

        if (is_null($section)) {
            throw new SectionCodeNotExists();
        }

        $this->checkCourseIsValidForRegister($section->course);

        return true;
    }

    public function checkCodeIsValidForOtherNewRegister(SectionCode $sectionCode, User $student): bool
    {

        $section = $this->sectionRepository->findByCode($sectionCode->get());

        if (is_null($section)) {
            throw new SectionCodeNotExists();
        }

        $this->checkCourseIsValidForRegister($section->course);

        $this->checkStudentIsAlreadyRegistered($section, $student);

        return true;
    }


    private function checkCourseIsValidForRegister(Course $course)
    {

        $now = Carbon::now()->endOfDay();

        if ($now->greaterThan($course->end_date->startOfDay())) {
            throw new CourseHasFinished();
        }
    }

    private function checkStudentIsAlreadyRegistered(Section $section, User $student)
    {
        foreach ($student->enrollment as $enrollment){
            if ($enrollment->isActive() AND $enrollment->section->isSame($section)){
                dd($section, $enrollment->section);
                throw new AlreadyRegisteredInCourse();
            }
        }
    }
}

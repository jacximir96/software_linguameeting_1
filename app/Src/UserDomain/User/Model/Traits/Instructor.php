<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\InstructorDomain\CoordinatorRequest\Model\CoordinatorRequest;
use App\Src\InstructorDomain\TeachingAssistant\Model\TeachingAssistant;
use App\Src\UniversityDomain\University\Model\University;

trait Instructor
{
    public function coordinatorRequest(){
        return $this->belongsTo(CoordinatorRequest::class)->withTrashed();
    }

    public function instructorOf()
    {
        return $this->hasMany(TeachingAssistant::class, 'instructor_id');
    }

    public function instructedBy()
    {
        return $this->hasMany(TeachingAssistant::class, 'assistant_id');
    }

    public function sectionAssistant()
    {
        return $this->hasMany(SectionTeachingAssistant::class, 'teacher_id');
    }

    public function sectionInstructor()
    {
        return $this->hasMany(Section::class, 'instructor_id');
    }

    public function university()
    {
        return $this->belongsToMany(University::class, 'university_instructor', 'instructor_id', 'university_id')
            ->whereNull('university_instructor.deleted_at');
    }

    //----

    public function courseAsCoordinator()
    {

        $courses = collect();

        foreach ($this->courseCoordinator as $courseCoordinator) {
            $courses->put($courseCoordinator->course->id, $courseCoordinator->course);
        }

        return $courses;
    }

    public function hasLingroCourse(): bool
    {

        foreach ($this->courseCoordinator as $courseCoordinator) {

            $course = $courseCoordinator->course;

            if ($course->isActive()) {

                if ($courseCoordinator->course->isLingro()) {
                    return true;
                }
            }
        }

        foreach ($this->sectionInstructor as $sectionInstructor) {

            if ($sectionInstructor->course->isLingro()) {
                return true;
            }
        }

        foreach ($this->sectionAssistant as $sectionAssistant) {

            if ($sectionAssistant->section->course->isLingro()) {
                return true;
            }
        }

        return false;
    }
}

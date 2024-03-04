<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Form\SectionAssignmentForm;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;

class SectionAssignment
{
    private Section $section;

    private SectionAssignmentForm $sectionAssignmentForm;

    public function __construct(Section $section, SectionAssignmentForm $sectionAssignmentForm)
    {
        $this->section = $section;
        $this->sectionAssignmentForm = $sectionAssignmentForm;
    }

    public function section(): Section
    {
        return $this->section;
    }

    public function sectionId(): int
    {
        return $this->section->id;
    }

    public function isSameSection(Section $section): bool
    {
        return $this->sectionId() == $section->id;
    }

    public function course(): Course
    {
        return $this->section->course;
    }

    public function form(): SectionAssignmentForm
    {
        return $this->sectionAssignmentForm;
    }
}

<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Service\SectionFormApi;

class SectionEditable
{
    private Section $section;

    private SectionFormApi $sectionForm;

    public function __construct(Section $section, SectionFormApi $sectionForm)
    {
        $this->section = $section;
        $this->sectionForm = $sectionForm;
    }

    public function section(): Section
    {
        return $this->section;
    }

    public function sectionForm(): SectionFormApi
    {
        return $this->sectionForm;
    }

    public function sectionId(): int
    {
        return $this->section->id;
    }

    public function course(): Course
    {
        return $this->section->course;
    }
}

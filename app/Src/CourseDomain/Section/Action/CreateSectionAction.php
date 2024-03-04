<?php

namespace App\Src\CourseDomain\Section\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Event\ChangeSectionEvent;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Request\SectionRequest;
use App\Src\CourseDomain\Section\Service\SectionChanges;
use App\Src\CourseDomain\Section\Service\SectionCodeGenerator;
use App\Src\UserDomain\User\Model\User;

class CreateSectionAction
{
    private SectionCodeGenerator $sectionCodeGenerator;

    public function __construct(SectionCodeGenerator $sectionCodeGenerator)
    {
        $this->sectionCodeGenerator = $sectionCodeGenerator;
    }

    public function handle(SectionRequest $request, Course $course, User $user): Section
    {
        $section = new Section();
        $section->course_id = $course->id;
        $section->name = $request->name;
        $section->instructor_id = $request->instructor_id;
        $section->num_students = $request->num_students;

        $section->lingro_code = $request->lingro_code;
        $section->is_free = $request->is_free ?? false;
        $section->code = $this->sectionCodeGenerator->generateCode();
        $section->make_ups_inst_section = 0;
        $section->make_ups_inst_section_used = 0;
        $section->see_recordings = false;

        $section->save();

        $sectionChanges = new SectionChanges($section);
        event(new ChangeSectionEvent($user, $sectionChanges));

        return $section;
    }
}

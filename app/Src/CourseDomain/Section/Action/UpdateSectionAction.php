<?php

namespace App\Src\CourseDomain\Section\Action;

use App\Src\CourseDomain\Section\Event\ChangeSectionEvent;
use App\Src\CourseDomain\Section\Exception\InstructorAlreadyAssigned;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Request\SectionRequest;
use App\Src\CourseDomain\Section\Service\SectionChanges;
use App\Src\UserDomain\User\Model\User;

class UpdateSectionAction
{
    private Section $section;

    public function handle(SectionRequest $request, Section $section, User $user): Section
    {
        $this->section = $section;

        $this->checkInstructorIsValid($request);

        $section->name = $request->name;
        $section->instructor_id = $request->instructor_id;
        $section->num_students = $request->num_students;
        $section->is_free = $request->is_free ?? false;

        $section->lingro_code = '';
        if ($section->course->isLingro()) {
            $section->lingro_code = $request->lingro_code;
        }

        $sectionChanges = new SectionChanges($section);
        event(new ChangeSectionEvent($user, $sectionChanges));

        $section->save();

        return $section;
    }

    private function checkInstructorIsValid(SectionRequest $request)
    {

        $instructor = User::find($request->instructor_id);

        foreach ($this->section->teachingAssistant as $sectionTeachingAssistant) {

            if ($instructor->isSame($sectionTeachingAssistant->teacher)) {
                throw new InstructorAlreadyAssigned();
            }
        }
    }
}

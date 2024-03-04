<?php

namespace App\Src\CourseDomain\SectionTeachingAssistant\Repository;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\UserDomain\User\Model\User;

class SectionTeachingAssistantRepository
{
    public function find(Section $section, User $teacherAssistant)
    {
        return SectionTeachingAssistant::query()
            ->where('section_id', $section->id)
            ->where('teacher_id', $teacherAssistant->id)
            ->first();
    }
}

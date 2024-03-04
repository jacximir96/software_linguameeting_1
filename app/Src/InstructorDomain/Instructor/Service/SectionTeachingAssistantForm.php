<?php

namespace App\Src\InstructorDomain\Instructor\Service;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;

class SectionTeachingAssistantForm extends BaseSearchForm
{
    public function configToCreate(Section $section)
    {
        $this->action = route('post.common.course.instructor.teching_assistant.section.create', $section->hashId());

        $this->model = [];
        $this->model['active'] = true;
    }
}

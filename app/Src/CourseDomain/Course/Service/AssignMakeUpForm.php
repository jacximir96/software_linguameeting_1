<?php

namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;

class AssignMakeUpForm extends BaseSearchForm
{
    public function configForCourse(Course $course)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.course.make_up.assign', $course->id);

        $this->configModel();
    }

    public function configForSection(Section $section)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.section.make_up.assign', $section->id);

        $this->configModel();
    }

    private function configModel()
    {
        $this->model['number_makeups'] = 1;
    }
}

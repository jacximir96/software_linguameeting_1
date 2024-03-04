<?php

namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class CourseBasicForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $levelOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(Course $course)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.course.update.basic', $course->id);

        $this->model = $course->toArray();

        $this->levelOptions = $this->fieldFormBuilder->obtainUniversityLevelOptions();
    }
}

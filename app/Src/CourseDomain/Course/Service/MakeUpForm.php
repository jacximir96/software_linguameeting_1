<?php

namespace App\Src\CourseDomain\Course\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class MakeUpForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $makeUpsSessionsOptions;

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

        $this->action = route('post.admin.course.make_up.update', $course->id);

        $this->model = $course->toArray();

        $this->makeUpsSessionsOptions = $this->fieldFormBuilder->obtainMakeUpsPurchase();
    }
}

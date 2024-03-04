<?php

namespace App\Src\CourseDomain\Section\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UniversityDomain\University\Model\University;

class SectionForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $instructorOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function instructorOptions(): array
    {
        return $this->instructorOptions;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate(Course $course)
    {
        $this->action = route('post.common.course.section.create', $course);

        $this->model = [];
        $this->model['active'] = true;

        $this->configCommonOptions($course->university);
    }

    public function configToEdit(Section $section)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.course.section.edit', $section);

        $this->model = $section->toArray();

        $this->configCommonOptions($section->course->university);
    }

    private function configCommonOptions(University $university)
    {
        $this->instructorOptions = $this->fieldFormBuilder->obtainInstructorsOptionsByUniversity($university);
    }
}

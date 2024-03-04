<?php
namespace App\Src\NotificationDomain\Notification\Presenter\Printer\Enrollment;


use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Collection;


class CourseChangedPrinter extends FieldPrinter
{

    public function __construct (array $data){
        parent::__construct($data);
    }

    public function key(): string
    {
        return $this->data()['key'];
    }

    public function keyField(): string
    {
        return 'new';
    }

    public function nameField(): string
    {
        return 'Course Changed';
    }

    public function sectionBefore ():string{
        return $this->obtainCourse('before')->name;
    }

    public function sectionAfter ():string{
        return $this->obtainCourse('after')->name;
    }

    public function change (string $moment):Collection{
        return collect();
    }

    private function obtainCourse (string $moment):Course{
        $sectionId = $this->data()['values']['section_id']['values'][$moment];

        $section = Section::withTrashed()->find($sectionId);

        return CourseRepository::findTrashed($section->course_id);
    }
}

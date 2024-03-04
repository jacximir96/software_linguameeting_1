<?php

namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EnrollmentBreadcrumb implements IBreadcrumb
{
    /**
     * @var Course
     */
    private Course $course;

    public function __construct (Course $course){

        $this->course = $course;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Course '.$this->course->name);
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

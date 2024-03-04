<?php

namespace App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowCourseBreadcrumb implements IBreadcrumb
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

        $itemLink = $this->buildIndexCourseLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag($this->course->name);
        $breadcrumb->push($tag);

        return $breadcrumb;
    }

    private function buildIndexCourseLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.instructor.course.index'), 'Active Courses', 'Active Courses');

        return new ItemLink($link);
    }
}

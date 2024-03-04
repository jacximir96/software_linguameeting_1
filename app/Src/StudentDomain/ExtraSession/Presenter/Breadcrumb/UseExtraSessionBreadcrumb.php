<?php
namespace App\Src\StudentDomain\ExtraSession\Presenter\Breadcrumb;


use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class UseExtraSessionBreadcrumb implements IBreadcrumb
{
    private Enrollment $enrollment;

    public function __construct (Enrollment $enrollment){

        $this->enrollment = $enrollment;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.student.enrollment.show', $this->enrollment->hashId()), 'Course', 'Show Course');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $text = 'Extra Session';
        $tag = new ItemTag($text);
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

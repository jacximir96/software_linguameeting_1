<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\Makeup;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;


class MakeupOptionsBreadcrumb implements IBreadcrumb
{


    private EnrollmentSession $enrollmentSession;

    public function __construct (EnrollmentSession $enrollmentSession){
        $this->enrollmentSession = $enrollmentSession;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.student.enrollment.show', $this->enrollment->id), 'Course', 'Show Course');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $text = 'Book Session: '.$this->sessionOrder->get();
        $link = HtmlLink::create(route('get.student.session.book.create.search_coach', [$this->enrollment->id, $this->sessionOrder->get()]), $text, 'Start Book Session');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Availability Found');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

<?php
namespace App\Src\StudentDomain\Makeup\Presenter\Breadcrumb;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class UseMakeupBreadcrumb implements IBreadcrumb
{
    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    public function __construct (Enrollment $enrollment, SessionOrder $sessionOrder){

        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.student.enrollment.show', $this->enrollment->hashId()), 'Course', 'Show Course');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $text = 'Make-Up for Session '.$this->sessionOrder->get();
        $tag = new ItemTag($text);
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

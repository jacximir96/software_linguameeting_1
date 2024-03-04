<?php
namespace App\Src\StudentRole\BookSession\Presenter\Breadcrumb;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class LastMinuteBreadcrumb implements IBreadcrumb
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

        $tag = new ItemTag('Last Minute: Session'.$this->sessionOrder->get());
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

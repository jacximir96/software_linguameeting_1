<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class ShowCoachBreadcrumb implements IBreadcrumb
{

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    private bool $isReschedule;

    public function __construct (Enrollment $enrollment, SessionOrder $sessionOrder, bool $isReschedule){

        $this->enrollment = $enrollment;
        $this->sessionOrder = $sessionOrder;
        $this->isReschedule = $isReschedule;
    }

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.student.enrollment.show', $this->enrollment->id), 'Course', 'Show Course');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $link = HtmlLink::create(route('get.student.session.book.create.search_coach', [$this->enrollment->id, $this->sessionOrder->get()]), $this->linkText(), $this->titleText());
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Coach Availability');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }

    private function linkText():string{

        if ($this->isReschedule){
            return 'Reschedule Session: '.$this->sessionOrder->get();
        }

        return 'Book Session: '.$this->sessionOrder->get();
    }

    private function titleText():string{

        if ($this->isReschedule){
            return 'Reschedule Session';
        }

        return 'Start Book Session';
    }
}

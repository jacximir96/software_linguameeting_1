<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession;

use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class ResultSearchCoachBreadcrumb implements IBreadcrumb
{

    private Enrollment $enrollment;

    private SessionOrder $sessionOrder;

    private bool $isReschedule;

    public function __construct (Enrollment $enrollment, SessionOrder $sessionOrder, bool $isReschedule = false){

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

        if ($this->isReschedule){
            $text = 'Reschedule Session: '.$this->sessionOrder->get();
        }
        else{
            $text = 'Book Session: '.$this->sessionOrder->get();
        }

        $link = HtmlLink::create(route('get.student.session.book.create.search_coach', [$this->enrollment->id, $this->sessionOrder->get()]), $text, 'Start Book Session');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Availability Found');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}

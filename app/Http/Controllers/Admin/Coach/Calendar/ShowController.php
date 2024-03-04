<?php

namespace App\Http\Controllers\Admin\Coach\Calendar;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Calendar\Presenter\Breadcrumb\CoachCalendarFromAdminBreadcrumb;
use App\Src\CoachDomain\CoachSchedule\Presenter\ShowCalendarPresenter;
use App\Src\UserDomain\User\Model\User;

class ShowController extends Controller
{

    use Breadcrumable;

    public function __invoke(User $coach)
    {
        $getEventsUrl = route('get.admin.api.coach.calendar.events.get', []);

        $presenter = app(ShowCalendarPresenter::class);
        $viewData = $presenter->handle($coach);

        $breadcrumb = new CoachCalendarFromAdminBreadcrumb($coach);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'getEventUrl' => $getEventsUrl,
            'timezone' => $coach->timezone,
            'viewData' => $viewData
        ]);

        return view('admin.coach.calendar.show');
    }
}

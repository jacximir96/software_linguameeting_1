<?php

namespace App\Http\Controllers\Coach\Calendar;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Calendar\Presenter\Breadcrumb\CoachCalendarBreadcrumb;


class ShowController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {
        $coach = user();

        $getEventsUrl = route('get.admin.api.coach.calendar.events.get', []);

        $breadcrumb = new CoachCalendarBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'getEventUrl' => $getEventsUrl,
            'timezone' => $coach->timezone,
        ]);

        return view('coach.calendar.show');
    }
}

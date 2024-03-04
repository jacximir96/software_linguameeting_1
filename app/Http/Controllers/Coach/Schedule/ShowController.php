<?php

namespace App\Http\Controllers\Coach\Schedule;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachSchedule\Presenter\Breadcrumb\CoachAvailabilityBreadcrumb;
use Carbon\Carbon;

class ShowController extends Controller
{
    use Breadcrumable;


    public function __invoke(string $startDate = null, string $endDate= null)
    {

        $coach = user();

        $getEventsUrl = route('get.admin.api.coach.schedule.events.get', []);

        if (!is_null($startDate) AND !is_null($endDate)){
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        }

        $breadcrumb = new CoachAvailabilityBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'getEventUrl' => $getEventsUrl,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return view('coach.schedule.show');
    }
}

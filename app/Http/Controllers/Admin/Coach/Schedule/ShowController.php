<?php

namespace App\Http\Controllers\Admin\Coach\Schedule;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachSchedule\Presenter\Breadcrumb\CoachScheduleFromAdminBreadcrumb;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ShowController extends Controller
{
    use Breadcrumable;

    public function __invoke(User $coach, string $startDate = null, string $endDate= null, ?TimeZone $timezone = null)
    {
        $getEventsUrl = route('get.admin.api.coach.schedule.events.get', []);

        if (!is_null($startDate) AND !is_null($endDate)){
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
        }

        $breadcrumb = new CoachScheduleFromAdminBreadcrumb($coach);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'getEventUrl' => $getEventsUrl,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'timezone' => $coach->timezone,
        ]);

        return view('admin.coach.schedule.show');
    }
}

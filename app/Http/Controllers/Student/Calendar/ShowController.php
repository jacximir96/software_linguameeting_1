<?php

namespace App\Http\Controllers\Student\Calendar;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Calendar\Presenter\Breadcrumb\StudentCalendarBreadcrumb;


class ShowController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {
        $student = user();

        $getEventsUrl = route('get.admin.api.student.calendar.events.get', []);

        $breadcrumb = new StudentCalendarBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'student' => $student,
            'getEventUrl' => $getEventsUrl,
            'timezone' => $student->timezone,
        ]);

        return view('student.calendar.show');
    }
}

<?php

namespace App\Src\CoachDomain\GoogleCalendar\Service;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\ShowSmallGroupSessionPresenter;
use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;

class SessionWrapper
{
    private Session $session;

    public function __construct(Session $session)
    {

        $this->session = $session;
    }

    public function courseName(): string
    {
        return $this->session->course->name;
    }

    //render views
    public function description(): string
    {

        $presenter = app(ShowSmallGroupSessionPresenter::class);
        $viewData = $presenter->handle($this->session);

        $htmlSession = view('admin.coach.calendar.session.raw.info_session', ['session' => $this->session])->render();

        $htmlCourse = view('admin.coach.calendar.session.raw.info_course', ['course' => $this->session->course])->render();

        $htmlStudents = view('admin.coach.calendar.session.raw.info_students', compact('viewData'))->render();

        $htmlMakeups = '';
        if ($viewData->makeupSessionsAssignments()->count()) {
            $htmlMakeups = view('admin.coach.calendar.session.raw.info_students_makeups')->render();
        }

        $html = $htmlSession.$htmlCourse.$htmlStudents.$htmlMakeups;

        return $html;
    }

    public function startWithTimezone(): Carbon
    {
        return $this->session->createTime('start_time');
    }

    public function endWithTimezone(TimeZone $timeZone): Carbon
    {
        return $this->session->createTime('end_time');
    }
}

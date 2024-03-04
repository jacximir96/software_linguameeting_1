<?php
namespace App\Http\Controllers\Student\Session\Calendar;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\ShowSmallGroupSessionPresenter;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;


class ShowSessionController extends Controller
{

    private SessionRepository $sessionRepository;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (SessionRepository $sessionRepository, EnrollmentSessionRepository $enrollmentSessionRepository){

        $this->sessionRepository = $sessionRepository;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function __invoke(Session $session)
    {

        $session->load($this->sessionRepository->relations());

        $presenter = app(ShowSmallGroupSessionPresenter::class);
        $viewData = $presenter->handle($session);

        $enrollmentSession = $this->enrollmentSessionRepository->enrollmentSessionBySessionAndStudent($session, user());

        view()->share([
            'enrollmentSession' => $enrollmentSession,
            'session' => $session,
            'timezone' => $this->userTimezone(),
            'viewData' => $viewData,
        ]);

        return view('student.calendar.session.show_session');
    }


}

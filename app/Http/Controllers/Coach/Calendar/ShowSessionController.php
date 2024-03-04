<?php
namespace App\Http\Controllers\Coach\Calendar;


use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Presenter\ShowSmallGroupSessionPresenter;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;


class ShowSessionController extends Controller
{

    private SessionRepository $sessionRepository;

    public function __construct (SessionRepository $sessionRepository){

        $this->sessionRepository = $sessionRepository;
    }

    public function __invoke(Session $session)
    {

        $session->load($this->sessionRepository->relations());

        $presenter = app(ShowSmallGroupSessionPresenter::class);
        $viewData = $presenter->handle($session);

        view()->share([
            'session' => $session,
            'timezone' => $session->coach->timezone,
            'viewData' => $viewData,
        ]);

        return view('admin.coach.calendar.show_session');
    }
}

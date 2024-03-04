<?php
namespace App\Http\Controllers\Coach\Class;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Session\Presenter\Breadcrumb\ClassTodayIndexBreadcrumb;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Service\HtmlFormatter;
use App\Src\Localization\TimeZone\Repository\TimeZoneRepository;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use Carbon\Carbon;


class ClassTodayIndexController extends Controller
{
    use Breadcrumable;

    private SessionRepository $sessionRepository;

    private PeriodsBuilder $periodsBuilder;

    public function __construct (SessionRepository $sessionRepository, PeriodsBuilder $periodsBuilder){
        $this->sessionRepository = $sessionRepository;
        $this->periodsBuilder = $periodsBuilder;
    }

    public function __invoke()
    {
        $coach = user();

        $timezone = TimeZoneRepository::findByName(userTimezoneName());
        $period = $this->periodsBuilder->buildTodayFromStartToEndFromTimezone($timezone);

        $sessions = $this->sessionRepository->obtainSessionForCoachInPeriod($coach, $period);

        $breadcrumb = new ClassTodayIndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'coach' => $coach,
            'sessions' => $sessions,
        ]);

        return view('coach.session.index');
    }
}

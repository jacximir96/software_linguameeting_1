<?php
namespace App\Http\Controllers\Student\Session\LastMinute;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsFull;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentRole\BookSession\Action\CreateLastMinuteSessionAction;
use App\Src\StudentRole\BookSession\Presenter\Breadcrumb\LastMinuteBreadcrumb;
use App\Src\StudentRole\BookSession\Presenter\LastMinutePresenter;
use App\Src\StudentRole\BookSession\Presenter\LastMinuteQuery;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LastMinuteController extends Controller
{

    use Breadcrumable, BookableController;

    //construct
    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    private ReviewStatsBuilder $reviewStatsBuilder;

    private CoachingWeekRepository $coachingWeekRepository;

    public function __construct (SessionOrderPeriodBuilder $sessionOrderPeriodBuilder, ReviewStatsBuilder $reviewStatsBuilder, CoachingWeekRepository $coachingWeekRepository){

        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
        $this->coachingWeekRepository = $coachingWeekRepository;
    }

    public function configView(Enrollment $enrollment, int $sessionOrder, string $dateSession, TimeHour $timeHour, string $coach = '')
    {
        //inicializar
        $sessionOrder = new SessionOrder($sessionOrder);
        $dateSession = Carbon::parse($dateSession);

        $this->cleanSession();

        //obtener las sesiones
        $query = $this->obtainLastMinuteQuery($dateSession, $timeHour, $enrollment);
        $presenter = app(LastMinutePresenter::class);
        $viewData = $presenter->handle($query);

        $coachingWeek = $this->coachingWeekRepository->obtainByCourseAndOrder($enrollment->course(), $sessionOrder->get());

        //estadísticas de los coaches
        $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($viewData->coaches());

        //breadcrumb
        $breadcrumb = new LastMinuteBreadcrumb($enrollment, $sessionOrder);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'course' => $enrollment->course(),
            'coachingWeek' => $coachingWeek,
            'enrollment' => $enrollment,
            'reviewsStatsCollection' => $reviewsStatsCollection,
            'sessionOrder' => $sessionOrder,
            'startDate' => Carbon::now(),
            'userTimezone' => $this->userTimezone(),
            'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
            'viewData' => $viewData,
        ]);

        return view('student.enrollment.session.last-minute.index');
    }

    public function selectSession (Enrollment $enrollment, int $sessionOrder, Session $session){


        try{

            DB::beginTransaction();

            $sessionOrder = new SessionOrder($sessionOrder);

            $action = app(CreateLastMinuteSessionAction::class);
            $action->handle($enrollment, $sessionOrder, $session);

            DB::commit();

            flash(trans('student.enrollment.session.create.create_success'))->success();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (SessionIsFull $exception){

            DB::rollback();

            flash('No es posible tu inscripción en la sesión ya que esta se encuentra con el aforo completo.')->error();

            return back()->withInput();

        }
        catch (HourLimitExceeded $exception){

            DB::rollback();

            flash('Sessions must be scheduled at least 12 hours in advance.')->error();

            return back()->withInput();

        }
        catch (\Throwable $exception){

            DB::rollBack();

            Log::error('There is an error when select session in last minute.', [
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'session' => $session,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.last-minute.error.create_session'))->error();

            return back()->withInput();

        }
    }

    private function obtainLastMinuteQuery(Carbon $dateSession, TimeHour $timeHour, Enrollment $enrollment): LastMinuteQuery
    {
        $start = Carbon::parse($dateSession->toDateString() . ' ' . $timeHour->start, $this->userTimezone()->name);
        $startUTC = $start->clone()->setTimezone('UTC');

        $end = Carbon::parse($dateSession->toDateString() . ' ' . $timeHour->end, $this->userTimezone()->name);
        $endUTC = $end->clone()->setTimezone('UTC');

        $period = new CarbonPeriod($startUTC, $endUTC);
        $query = new LastMinuteQuery($enrollment->course(), $period);

        return $query;
    }
}

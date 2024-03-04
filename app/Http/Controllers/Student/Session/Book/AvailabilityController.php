<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\DateIsIncorrect;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession\ResultSearchCoachBreadcrumb;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession\SearchCoachBreadcrumb;
use App\Src\StudentDomain\Makeup\Service\MakeupInfoSession;
use App\Src\StudentRole\BookSession\Request\SearchCoachRequest;
use App\Src\StudentRole\BookSession\Service\SearchCoachForm;
use App\Src\StudentRole\BookSession\Service\ShowCoachForm;
use App\Src\StudentRole\Coach\Presenter\BookSessionCoachPresenter;
use App\Src\TimeDomain\Time\Model\Time;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;


class AvailabilityController extends Controller
{

    use Breadcrumable, BookableController;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;
    private CoachReviewRepository $coachReviewRepository;

    public function __construct (SessionOrderPeriodBuilder $sessionOrderPeriodBuilder, CoachReviewRepository $coachReviewRepository){

        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->coachReviewRepository = $coachReviewRepository;
    }

    //primera pantalla con el calendario de otras sesiones del curso y el formulario de búsqueda de sesiones por día y tramo horario
    public function configSelectDateView(Enrollment $enrollment, int $sessionOrder)
    {

        $this->cleanSession();

        $sessionOrder = new SessionOrder($sessionOrder);

        $breadcrumb = new SearchCoachBreadcrumb($enrollment, $sessionOrder);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $searchCoachForm = app(SearchCoachForm::class);
        $searchCoachForm->configForSelectView($enrollment, $sessionOrder);

        $sessionOrderPeriod = $this->sessionOrderPeriodBuilder->build($enrollment, $sessionOrder);

        $this->sendDataForApiCallToView($enrollment, $sessionOrder, [], session()->has('isMakeup'));

        view()->share([
            'course' => $enrollment->course(),
            'enrollment' => $enrollment,
            'searchCoachForm' => $searchCoachForm,
            'sessionOrderPeriod' => $sessionOrderPeriod,
            'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
            'userTimezone' => $this->userTimezone(),
        ]);

        return view('student.enrollment.session.book.create_book_search_coach');
    }

    //Este es un paso intermedio. Aquí se llega desde el formulario de búsqueda de otros coach seleccionando fecha, tramo horario y opcionalmente nombre del coach.
    //convierte a url 'full'. Hacemos esto para estar siempre sobre una url y no trabajar sobre request de formularios que no permiten ir hacia atrás
    public function searchCoach(SearchCoachRequest $request, Enrollment $enrollment, int $sessionOrder)
    {
        //para evitar el mensaje de recarga de formulario al darle al 'volver' en el navegador
        return redirect()->route('get.student.session.book.create.search_coach_full', [
            $enrollment->hashId(),
            $sessionOrder,
            $request->dateSession,
            $request->time_id,
            $request->coach ?? ''
        ]);
    }


    //aquí ya estamos sobre una uri completa donde se muestran los coach encontrados
    public function searchCoachFull(Enrollment $enrollment, int $sessionOrder, string $dateSession, Time $time, string $coach = ''){

        //con esto tenemos que reconstruir la clase Request (usada en form y presenter) ya que en esta petición estamos entrando a través de una petición GET (no POST)
        request()->merge([
            'dateSession' => $dateSession,
            'time_id' => $time->id,
            'coach' => $coach
        ]);
        $request = app(SearchCoachRequest::class);

        try {

            $sessionOrder = new SessionOrder($sessionOrder);

            $this->checkDate($enrollment, $sessionOrder, $request);

            $breadcrumb = new ResultSearchCoachBreadcrumb($enrollment, $sessionOrder, session()->has('isReschedule'));
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            //formulario buscador inicial
            $searchCoachForm = app(SearchCoachForm::class);
            $searchCoachForm->configForSelectView($enrollment, $sessionOrder);

            //obtener disponiblidad
            $presenter = app(BookSessionCoachPresenter::class);
            $viewData = $presenter->handle($request, $enrollment);

            //formulario para mostrar disponibilidad de cada coach
            $showCoachForm = app(ShowCoachForm::class, [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
            ]);

            //info sesión
            $sessionOrderPeriod = $this->sessionOrderPeriodBuilder->build($enrollment, $sessionOrder);

            $this->sendDataForApiCallToView($enrollment, $sessionOrder, [], session()->has('isMakeup'));

            //datos a la vista
            view()->share([
                //'coachingWeek' => $coachingWeek,
                'course' => $enrollment->course(),
                'enrollment' => $enrollment,
                'isMakeup' => session()->has('isMakeup'),
                'request' => $request,
                'searchCoachForm' => $searchCoachForm,
                'sessionOrder' => $sessionOrder,
                'showCoachForm' => $showCoachForm,
                'sessionOrderPeriod' => $sessionOrderPeriod,
                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
                'studentTimezone' => $enrollment->user->timezone,
                'viewData' => $viewData
            ]);

            if (session()->has('isMakeup')){
               $this->sendDataToViewWhenIsMakeup();
            }

            return view('student.enrollment.session.book.show_availability_coaches');

        } catch (DateIsIncorrect $exception){

            flash('La fecha indicada es incorrecta.')->error();

            if (session()->has('isReschedule')){
                return redirect()->route('get.student.session.book.reschedule.init', session()->get('isReschedule')['enrollment_session_id']);
            }

            return redirect()->route('get.student.session.book.create.search_coach', [$enrollment->hashId(), $sessionOrder->get()]);
        }

        catch (\Throwable $exception) {

            Log::error('There is an error when search coach for select book session.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.book.error.search_coach.general'))->error();

            return back()->withInput();
        }

    }

    private function checkDate (Enrollment $enrollment, SessionOrder $sessionOrder, SearchCoachRequest $request):void{

        $dateSession = Carbon::parse($request->dateSession);

        if ($dateSession->isPast()){
            return;
        }

        $period = $this->obtainPeriod($enrollment, $sessionOrder, $dateSession);

        if (is_null($period) OR !$period->contains($dateSession)){
            throw new DateIsIncorrect();
        }
    }

    private function obtainPeriod(Enrollment $enrollment, SessionOrder $sessionOrder, Carbon $dateSession):?CarbonPeriod{

        if ($enrollment->course()->isFlex()){
            return $enrollment->course()->period();
        }

        // course weeks
        if(session()->has('isReschedule')){

            $enrollmentSessionId = session()->get('isReschedule')['enrollment_session_id'];
            $enrollmentSession = EnrollmentSession::find($enrollmentSessionId);

            if ($enrollmentSession->isMakeup()){
                return  $enrollmentSession->enrollment->course()->makeup()->first()->period();
            }

            return $enrollmentSession->coachingWeek->period();
        }
        elseif (session()->has('isMakeup')){

            $course = $enrollment->course();

            if ($course->onlyWeekMakeups()){

                //obtiene el coaching week de la sesión perdida..es la újnica que se podría utilizar en este caso de configuración del curso.
                $sessionOrder = session()->get('isMakeup')['recovered']['session_order'];

                $sessionOrder = new SessionOrder($sessionOrder);
                $coachingWeek = $course->obtainCoachingWeekBySessionOrder($sessionOrder);
            }
            else{
                //obtenener el coaching week correspondiente a la fecha seleccionada
                $coachingWeek = $course->obtainCoachingWeekFromDate($dateSession);
            }

            if ( is_null($coachingWeek) ) {
                return null;
            }

            if( $coachingWeek->isPast() ) {
                return null;
            }

            return $coachingWeek->period();
        }

        $coachingWeek = $enrollment->course()->obtainCoachingWeekBySessionOrder($sessionOrder);

        return $coachingWeek->period();

    }

    private function sendDataToViewWhenIsMakeup (){

        $makeupInfoSession = new MakeupInfoSession(session()->get('isMakeup'));

        if ($makeupInfoSession->isBookedSession()){

            $enrollmentSession = $makeupInfoSession->enrollmentSession();

            $reviewsStats = $this->coachReviewRepository->reviewStats($enrollmentSession->session->coach);
            view()->share([
                'enrollmentSession' => $enrollmentSession,
                'isBoookedSession' => true,
                'makeupInfoSession' => $makeupInfoSession,
                'reviewsStats' => $reviewsStats,
                'session' => $enrollmentSession->session
            ]);

        }
        else{

            view()->share([
                'isBoookedSession' => false,
                'makeupInfoSession' => $makeupInfoSession,
            ]);
        }
    }
}

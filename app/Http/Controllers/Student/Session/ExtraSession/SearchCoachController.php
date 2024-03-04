<?php

namespace App\Http\Controllers\Student\Session\ExtraSession;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\DateIsIncorrect;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionOrderIsInvalid;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\ExtraSession\Presenter\Breadcrumb\UseExtraSessionBreadcrumb;
use App\Src\StudentDomain\ExtraSession\Repository\ExtraSessionRepository;
use App\Src\StudentDomain\ExtraSession\Service\SearchCoachForm;
use App\Src\StudentDomain\ExtraSession\Request\SearchCoachRequest;
use App\Src\StudentRole\BookSession\Service\ShowCoachInExtraSessionForm;
use App\Src\StudentRole\BookSession\Service\ShowCoachForm;
use App\Src\StudentRole\Coach\Presenter\BookSessionCoachPresenter;
use App\Src\TimeDomain\Time\Model\Time;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;


//busca coach
class SearchCoachController extends Controller
{
    use Breadcrumable, BookableController, ExtraSessionable;

    private CoachReviewRepository $coachReviewRepository;

    private CoachReviewOptionRepository $coachReviewOptionRepository;

    private CourseRepository $courseRepository;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    private ExtraSessionRepository $extraSessionRepository;


    public function __construct (CoachReviewRepository $coachReviewRepository,
                                 CoachReviewOptionRepository $coachReviewOptionRepository,
                                 CourseRepository $courseRepository,
                                 SessionOrderPeriodBuilder $sessionOrderPeriodBuilder,
                                 EnrollmentSessionRepository $enrollmentSessionRepository,
                                 ExtraSessionRepository $extraSessionRepository){
        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachReviewOptionRepository = $coachReviewOptionRepository;
        $this->courseRepository = $courseRepository;
        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
        $this->extraSessionRepository = $extraSessionRepository;
    }


    //Este es un paso intermedio. Aquí se llega desde el formulario de búsqueda y redirecciona al Get.
    //Hacemos esto para estar siempre sobre una url y no trabajar sobre request de formularios que no permiten ir hacia atrás
    public function postRequest(SearchCoachRequest $request, Enrollment $enrollment, int $sessionOrder)
    {

        $this->checkSessionOrderIsValid($enrollment, $sessionOrder);


        if ($request->has('coaching_week_id')){
            session()->put('coachingWeekIdInExtraSession', $request->coaching_week_id);
        }

        //para evitar el mensaje de recarga de formulario al darle al 'volver' en el navegador
        return redirect()->route('get.student.session.book.extra_session.search_coach', [
            $enrollment->hashId(),
            $sessionOrder,
            $request->dateSession,
            $request->time_id,
            $request->coach ?? ''
        ]);
    }


    public function getRequest(Enrollment $enrollment, int $sessionOrder, string $dateSession, Time $time, string $coach = ''){
        try {

            $this->checkSessionOrderIsValid($enrollment, $sessionOrder);

            request()->merge([
                'dateSession' => $dateSession,
                'time_id' => $time->id,
                'coach' => $coach,
                'coaching_week_id' => session()->get('coachingWeekIdInExtraSession') ?? null
            ]);
            $request = app(SearchCoachRequest::class);

            $this->checkDate($enrollment, $request);

            $sessionOrder = new SessionOrder($sessionOrder);

            $breadcrumb = new UseExtraSessionBreadcrumb($enrollment);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            //formulario buscador inicial
            $searchCoachForm = app(SearchCoachForm::class);
            $searchCoachForm->configForSelectView($enrollment, $sessionOrder);

            //obtener disponiblidad
            $presenter = app(BookSessionCoachPresenter::class);
            $viewData = $presenter->handle($request, $enrollment);

            //formulario para mostrar disponibilidad de cada coach
            $showCoachForm = app(ShowCoachInExtraSessionForm::class, [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
            ]);

            //info sesión
            //$sessionOrderPeriod = $this->sessionOrderPeriodBuilder->build($enrollment, $sessionOrder);
            //$this->sendDataForApiCallToView($enrollment, $sessionOrder, [], session()->has('isMakeup'));
            $this->sendCoachingWeekToView($request);

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
                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
                'studentTimezone' => $enrollment->user->timezone,
                'viewData' => $viewData
            ]);

            return view('student.enrollment.session.book.show_availability_coaches_extra_session');

        }
        catch (SessionOrderIsInvalid $exception){

            flash('Session order parameter is incorrect.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }

        catch (DateIsIncorrect $exception){

            flash('La fecha indicada es incorrecta.')->error();

            if (session()->has('isReschedule')){
                return redirect()->route('get.student.session.book.reschedule.init', session()->get('isReschedule')['enrollment_session_id']);
            }

            return redirect()->route('get.student.session.book.extra_session.use', $enrollment->hashId());
        }

        catch (\Throwable $exception) {



            Log::error('There is an error when search coach for select book session.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.book.error.search_coach.general'))->error();

            return redirect()->route('get.student.session.book.extra_session.use', $enrollment->hashId());
        }

    }

    private function checkDate (Enrollment $enrollment, SearchCoachRequest $request):void{

        $period = $this->obtainPeriod($enrollment, $request);

        $dateSession = Carbon::parse($request->dateSession);

        if (is_null($period) OR !$period->contains($dateSession)){
            throw new DateIsIncorrect();
        }
    }

    private function obtainPeriod(Enrollment $enrollment, SearchCoachRequest $request):CarbonPeriod
    {
        if ($enrollment->course()->isFlex()) {
            return $enrollment->course()->period();
        }

        $coachingWeek = CoachingWeek::find($request->coaching_week_id);

        return $coachingWeek->period();
    }

    private function sendCoachingWeekToView ( SearchCoachRequest $request){

        $coachingWeek = CoachingWeek::find($request->coaching_week_id);

        if ($coachingWeek){
            view()->share([
                'coachingWeek' => $coachingWeek
            ]);
        }

    }
}

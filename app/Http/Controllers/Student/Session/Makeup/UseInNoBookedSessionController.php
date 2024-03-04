<?php

namespace App\Http\Controllers\Student\Session\Makeup;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\SessionHasMakeupAssigned;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Presenter\Breadcrumb\UseMakeupBreadcrumb;
use App\Src\StudentDomain\Makeup\Service\MakeupSearcher;
use App\Src\StudentRole\BookSession\Service\SearchCoachForm;
use Illuminate\Support\Facades\Log;


//muestra vista
class UseInNoBookedSessionController extends Controller
{
    use Breadcrumable, BookableController;

    private CoachReviewRepository $coachReviewRepository;

    private CoachReviewOptionRepository $coachReviewOptionRepository;

    private CourseRepository $courseRepository;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (CoachReviewRepository $coachReviewRepository,
                                 CoachReviewOptionRepository $coachReviewOptionRepository,
                                 CourseRepository $courseRepository,
                                 SessionOrderPeriodBuilder $sessionOrderPeriodBuilder,
                                 EnrollmentSessionRepository $enrollmentSessionRepository){
        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachReviewOptionRepository = $coachReviewOptionRepository;
        $this->courseRepository = $courseRepository;
        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function __invoke(Enrollment $enrollment, int $sessionOrder)
    {
        try {

            $sessionOrder = new SessionOrder($sessionOrder);

            $this->cleanSession();

            $isMakeupInfo = [
                'type' => 'not_booked_session',
                'recovered' => [
                    'enrollment_id' => $enrollment->hashId(),
                    'session_order' => $sessionOrder->get(),
                ]
            ];
            session()->put('isMakeup', $isMakeupInfo);

            $course = $enrollment->course();

            $breadcrumb = new UseMakeupBreadcrumb($enrollment, $sessionOrder);
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $searchCoachForm = app(SearchCoachForm::class);
            $searchCoachForm->configForSelectView($enrollment, $sessionOrder);

            $makeupSearcher = app(MakeupSearcher::class);
            $makeupAvailability = $makeupSearcher->searchFromEnrollment($enrollment);

            $this->configDatesAndSendToView($enrollment, $sessionOrder);

            view()->share([
                'course' => $course,
                'enrollment' => $enrollment,
                'isBoookedSession' => false,
                'makeupAvailability' => $makeupAvailability,
                'searchCoachForm' => $searchCoachForm,
                'sessionOrder' => $sessionOrder,
                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
            ]);

            return view('student.enrollment.session.makeup.use_makeup');

        } catch (SessionHasMakeupAssigned $exception){

            flash(trans('student.enrollment.session.makeup.error.makeup_has_recovered'))->error();

            return back();

        }
        catch (\Throwable $exception) {



            Log::error('There is an error when show info to create makeup in no booked session.', [
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder->get(),
                'exception' => $exception,
            ]);

            flash('Lo sentimos, pero se ha producido un error creando el Make-up.')->error();

            return back()->withInput();
        }
    }


    //datos a la vista para poder hacer llamadas api y cargar calendarios...etc.
    private function configDatesAndSendToView(Enrollment $enrollment, SessionOrder $sessionOrder){

        $sessionOrderPeriod = $this->sessionOrderPeriodBuilder->build($enrollment, $sessionOrder);

        $config = [];
        $config['sessionOrderPeriod'] = $sessionOrderPeriod;

        $this->sendDataForApiCallToView($enrollment, $sessionOrder, $config, true);
    }
}

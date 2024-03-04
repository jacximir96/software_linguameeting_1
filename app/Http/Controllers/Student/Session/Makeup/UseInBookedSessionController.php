<?php

namespace App\Http\Controllers\Student\Session\Makeup;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\SessionHasMakeupAssigned;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
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
class UseInBookedSessionController extends Controller
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

    public function __invoke(EnrollmentSession $enrollmentSession)
    {
        try {

            $this->cleanSession();

            $this->checkSessionHasMakeupAssigned($enrollmentSession);

            $isMakeupInfo = [
                'type' => 'booked_session',
                'recovered' => [
                    'enrollment_session_id' => $enrollmentSession->hashId(),
                ]
            ];
            session()->put('isMakeup', $isMakeupInfo);

            $course = $enrollmentSession->enrollment->course();

            $breadcrumb = new UseMakeupBreadcrumb($enrollmentSession->enrollment, $enrollmentSession->sessionOrder());
            $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

            $searchCoachForm = app(SearchCoachForm::class);
            $searchCoachForm->configForSelectView($enrollmentSession->enrollment, $enrollmentSession->sessionOrder());

            $reviewsStats = $this->coachReviewRepository->reviewStats($enrollmentSession->session->coach);

            $makeupSearcher = app(MakeupSearcher::class);
            $makeupAvailability = $makeupSearcher->searchFromEnrollment($enrollmentSession->enrollment);

            $this->configDatesAndSendToView($enrollmentSession->enrollment, $enrollmentSession->sessionOrder());

            view()->share([
                'course' => $course,
                'enrollmentSession' => $enrollmentSession,
                'enrollment' => $enrollmentSession->enrollment,
                'isBoookedSession' => true,
                'makeupAvailability' => $makeupAvailability,
                'reviewsStats' => $reviewsStats,
                'searchCoachForm' => $searchCoachForm,
                'session' => $enrollmentSession->session,

                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
            ]);

            return view('student.enrollment.session.makeup.use_makeup');

        } catch (SessionHasMakeupAssigned $exception){

            flash(trans('student.enrollment.session.makeup.error.makeup_has_recovered'))->error();

            return back();

        }
        catch (\Throwable $exception) {



            Log::error('There is an error when show info to create makeup.', [
                'enrollmentSession' => $enrollmentSession,
                'exception' => $exception,
            ]);

            flash('Lo sentimos, pero se ha producido un error creando el Make-up.')->error();

            return back()->withInput();
        }
    }

    private function checkSessionHasMakeupAssigned (EnrollmentSession $enrollmentSession){

        $sessionRecovered = $this->enrollmentSessionRepository->obtainRecovered($enrollmentSession);

        if ($sessionRecovered){
            throw new SessionHasMakeupAssigned();
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

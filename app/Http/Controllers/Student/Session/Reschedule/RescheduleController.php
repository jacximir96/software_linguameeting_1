<?php
namespace App\Http\Controllers\Student\Session\Reschedule;


use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Session\Book\BookableController;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession\RescheduleSearchCoachBreadcrumb;
use App\Src\StudentRole\BookSession\Service\SearchCoachForm;
use Carbon\Carbon;


class RescheduleController extends Controller
{

    use Breadcrumable, BookableController;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct (SessionOrderPeriodBuilder $sessionOrderPeriodBuilder, ReviewStatsBuilder $reviewStatsBuilder){

        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }

    public function configSelectDateView(EnrollmentSession $enrollmentSession)
    {

        $this->cleanSession();

        session()->put('isReschedule', [
            'enrollment_session_id' => $enrollmentSession->hashId()
        ]);

        $coaches = collect();
        $coaches->push($enrollmentSession->session->coach);
        $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($coaches);

        if ( ! $enrollmentSession->canChangeStatus(config('linguameeting.session.limits.reschedule_up_in_hours'))) {

            view()->share([
                'enrollmentSession' => $enrollmentSession,
                'reviewsStatsCollection' => $reviewsStatsCollection,
                'session' => $enrollmentSession->session,
            ]);

            return view('student.enrollment.session.reschedule.cannot_rescheedule');
        }

        $sessionOrder = $enrollmentSession->sessionOrder();

        $sessionOrderPeriod = $this->sessionOrderPeriodBuilder->build($enrollmentSession->enrollment, $sessionOrder);

        $breadcrumb = new RescheduleSearchCoachBreadcrumb($enrollmentSession->enrollment, $sessionOrder);
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $searchCoachForm = app(SearchCoachForm::class);
        $searchCoachForm->configForSelectView($enrollmentSession->enrollment, $sessionOrder);

        $this->sendDataForApiCallToView($enrollmentSession->enrollment, $sessionOrder, [], $enrollmentSession->isMakeup());

        view()->share([

            'course' => $enrollmentSession->session->course,
            'enrollment' => $enrollmentSession->enrollment,
            'enrollmentSession' => $enrollmentSession,
            'reviewsStatsCollection' => $reviewsStatsCollection,
            'searchCoachForm' => $searchCoachForm,
            'session' => $enrollmentSession->session,
            'sessionOrderPeriod' => $sessionOrderPeriod,
            'startDate' => Carbon::now(),
            'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
        ]);

        return view('student.enrollment.session.reschedule.index');
    }
}

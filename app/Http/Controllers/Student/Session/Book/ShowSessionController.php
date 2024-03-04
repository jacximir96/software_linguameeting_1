<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewStatsBuilder;
use App\Src\CourseDomain\Schedule\Presenter\CalendarSessionFacade;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession\ResultSearchCoachBreadcrumb;
use App\Src\StudentRole\BookSession\Service\SearchCoachForm;
use App\Src\StudentRole\BookSession\Service\ShowCoachForm;
use App\Src\StudentRole\Coach\Presenter\BookSessionCoachPresenter;
use Illuminate\Support\Facades\Log;


class ShowSessionController extends Controller
{

    private ReviewStatsBuilder $reviewStatsBuilder;

    public function __construct(ReviewStatsBuilder $reviewStatsBuilder)
    {
        $this->reviewStatsBuilder = $reviewStatsBuilder;
    }


    public function __invoke(Session $session, Enrollment $enrollment, int $sessionOrder)
    {
        try {

            $sessionFacade = new CalendarSessionFacade($session);

            $sessionOrder = new SessionOrder($sessionOrder);

            $coaches = [$session->coach];
            $coaches = collect($coaches);

            $reviewsStatsCollection = $this->reviewStatsBuilder->buildCollection($coaches);

            view()->share([
                'coach' => $session->coach,
                'enrollment' => $enrollment,
                'session' => $sessionFacade,
                'noFooter' => true,
                'reviewsStatsCollection' => $reviewsStatsCollection,
                'sessionOrder' => $sessionOrder,
                'utcTimezoneName' => TimeZone::TIMEZONE_UTC,
                'userTimezone' => $this->userTimezone(),
            ]);

            return view( 'student.enrollment.session.api.session_modal');


        } catch (\Throwable $exception) {

            Log::error('There is an error when show session to book.', [
                'request' => $request,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.book.error.search_coach.general'))->error();

            return back()->withInput();
        }
    }


}

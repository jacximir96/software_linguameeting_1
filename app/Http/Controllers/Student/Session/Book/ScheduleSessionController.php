<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Schedule\Presenter\ScheduleNextSessionsPresenter;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb\BookSession\ResultSearchCoachBreadcrumb;
use App\Src\StudentRole\BookSession\Action\ScheduleSessionAction;
use App\Src\StudentRole\BookSession\Service\SearchCoachForm;
use App\Src\StudentRole\BookSession\Service\ShowCoachForm;
use App\Src\StudentRole\Coach\Presenter\BookSessionCoachPresenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


//Agendar una sessión ya existente
class ScheduleSessionController extends Controller
{

    use Breadcrumable;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    public function __construct (SessionOrderPeriodBuilder $sessionOrderPeriodBuilder){

        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
    }

    public function __invoke(Session $session, Enrollment $enrollment, int $sessionOrder)
    {
        try {

            DB::beginTransaction();

            $sessionOrder = new SessionOrder($sessionOrder);

            $action = app(ScheduleSessionAction::class);
            $action->handle($session, $enrollment, $sessionOrder);

            DB::commit();

            flash(trans('student.enrollment.session.schedule.create.create_success'))->success();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when student schedule session.', [
                'session' => $session,
                'enrollment' => $enrollment,
                'sessionOrder' => $sessionOrder,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.join.error.general_error'))->error();

            return back()->withInput();
        }
    }


}

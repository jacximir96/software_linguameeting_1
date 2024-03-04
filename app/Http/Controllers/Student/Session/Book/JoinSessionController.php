<?php
namespace App\Http\Controllers\Student\Session\Book;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrderPeriodBuilder;
use Illuminate\Support\Facades\Log;

//el estudiante quiere comenzar una sessión
class JoinSessionController extends Controller
{

    use Breadcrumable;

    private SessionOrderPeriodBuilder $sessionOrderPeriodBuilder;

    public function __construct (SessionOrderPeriodBuilder $sessionOrderPeriodBuilder){

        $this->sessionOrderPeriodBuilder = $sessionOrderPeriodBuilder;
    }

    public function __invoke(EnrollmentSession $enrollmentSession)
    {
        try {

            if ($enrollmentSession->session->isPossibleJoinSession()){
                flash('You will be able to join the session 2 minutes before it starts.')->warning();
                return back();
            }

            return redirect()->to($enrollmentSession->session->coach->zoomMeeting->join_url);

        } catch (\Throwable $exception) {

            Log::error('There is an error when student join session.', [
                'enrollmentSession' => $enrollmentSession,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.join.error.general_error'))->error();

            return back()->withInput();
        }
    }


}

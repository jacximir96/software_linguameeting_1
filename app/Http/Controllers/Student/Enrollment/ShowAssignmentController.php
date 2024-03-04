<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Assignment\Presenter\StudentRole\ShowAssignmentPresenter;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\Log;

class ShowAssignmentController extends Controller
{

    public function __invoke(EnrollmentSession $enrollmentSession)
    {
        try {

            $presenter = app(ShowAssignmentPresenter::class);
            $viewData = $presenter->handle($enrollmentSession->enrollment);

            view()->share([
                'enrollment' => $enrollmentSession->enrollment,
                'enrollmentSession' => $enrollmentSession,
                'viewData' => $viewData
            ]);

            return view('student.enrollment.assignments.show');
        }
        catch (\Throwable $exception) {

            Log::error('When show session assignment as a student.', [
                'user' => user(),
                'enrollmentSession' => $enrollmentSession,
                'exception' => $exception,
            ]);

            flash('Sorry, there is an error show assignment.');

            return view('common.feedback_modal');
        }
    }
}

<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Assignment\Presenter\StudentRole\ShowAssignmentPresenter;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\Log;

class ShowAssignmentFromEnrollmentController extends Controller
{

    public function __invoke(Enrollment $enrollment)
    {
        try {

            $presenter = app(ShowAssignmentPresenter::class);
            $viewData = $presenter->handle($enrollment);

            view()->share([
                'enrollment' => $enrollment->enrollment,
                'viewData' => $viewData
            ]);

            return view('student.enrollment.assignments.show');
        }
        catch (\Throwable $exception) {

            Log::error('When show session assignment as a student from enrollment.', [
                'user' => user(),
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            flash('Sorry, there is an error show assignment.');

            return view('common.feedback_modal');
        }
    }
}

<?php
namespace App\Http\Controllers\Student\Session;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\Enrollment\Action\SetIntroSessionAction;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Illuminate\Support\Facades\Log;

class SetIntroSessionController extends Controller
{

    public function __invoke(Enrollment $enrollment)
    {
        try {

            $action = app(SetIntroSessionAction::class);
            $action->handle($enrollment);

            return response()->json(['message' => trans('student.session.intro_session.success')], 200);
        }
        catch (\Throwable $exception) {

            Log::error('When updated intro session in a enrollment.', [
                'user' => user(),
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            return response()->json(trans('student.session.intro_session.error.general'), 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\Course\Session;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Action\ChangeSessionStatusAction;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Request\ChangeSessionStatusRequest;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeSessionStatusController extends Controller
{
    public function __invoke(ChangeSessionStatusRequest $request, EnrollmentSession $enrollmentSession)
    {
        try {
            DB::beginTransaction();

            $sessionStatus = SessionStatus::find($request->session_status_id);

            $action = app(ChangeSessionStatusAction::class);
            $action->handle($enrollmentSession, $sessionStatus);

            DB::commit();

            return response('Status session changed successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollback();

            $message = 'There is an error when update session status';
            Log::error($message, [
                'enrollmentSession' => $enrollmentSession,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response($message, 500);
        }
    }
}

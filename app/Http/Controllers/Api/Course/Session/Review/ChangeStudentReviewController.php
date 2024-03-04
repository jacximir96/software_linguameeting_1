<?php

namespace App\Http\Controllers\Api\Course\Session\Review;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\StudentReview\Action\ChangeStudentReviewAction;
use App\Src\CourseDomain\SessionDomain\StudentReview\Exception\SessionHasNoReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\ChangeStudentReviewRequest;
use Illuminate\Support\Facades\Log;


class ChangeStudentReviewController extends Controller
{
    public function __invoke(ChangeStudentReviewRequest $request, EnrollmentSession $enrollmentSession)
    {

        try {

            if ( ! $enrollmentSession->hasFeedback()){
                throw new SessionHasNoReview();
            }

            $sessionFeedback = $enrollmentSession->feedback;

            $sessionFeedbackType = $request->sessionFeedbackTypeSelected();

            $action = app(ChangeStudentReviewAction::class);
            $action->handle($sessionFeedback, $sessionFeedbackType, $request->id());

            return response('Status session changed successfully', 200);

        } catch (SessionHasNoReview $exception){

            $message = 'Session has no feedback associated.';

            Log::error($message, [
                'enrollmentSession' => $enrollmentSession,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response($message, 500);

        }
        catch (\Throwable $exception) {

            $message = 'There is an error when update session feedback';

            Log::error($message, [
                'session' => $session,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response($message, 500);
        }
    }
}

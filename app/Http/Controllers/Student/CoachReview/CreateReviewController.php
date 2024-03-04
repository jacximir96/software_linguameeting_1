<?php

namespace App\Http\Controllers\Student\CoachReview;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Action\CreateCoachReviewAction;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Request\CoachReviewRequest;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\CoachReviewForm;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

//crea la valoración del estudiante al coach
class CreateReviewController extends Controller
{

    public function configView(EnrollmentSession $enrollmentSession)
    {

        if ($enrollmentSession->coachReview){

            view()->share([
                'coachReview' => $enrollmentSession->coachReview,
                'coachReviewExists' => true,
            ]);

            return view('student.enrollment.session.coach-review.form');

        }

        $form = app(CoachReviewForm::class);
        $form->configForCreate($enrollmentSession);

        view()->share([
            'enrollmentSession' => $enrollmentSession,
            'form' => $form,
        ]);

        return view('student.enrollment.session.coach-review.form');
    }

    public function create(CoachReviewRequest $request, EnrollmentSession $enrollmentSession)
    {
        try {

            DB::beginTransaction();

            $coach = $enrollmentSession->session->coach;

            $action = app(CreateCoachReviewAction::class);
            $feedback = $action->handle($request, $enrollmentSession, $coach);

            DB::commit();

            flash(trans('coach.feedback.coach_review.success.on_create'))->success();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create coach review.', [
                'enrollmentSession' => $enrollmentSession,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.feedback.coach_review.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

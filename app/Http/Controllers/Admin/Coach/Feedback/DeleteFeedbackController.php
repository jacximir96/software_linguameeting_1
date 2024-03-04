<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action\DeleteCoachFeedbackAction;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use Illuminate\Support\Facades\Log;


class DeleteFeedbackController extends Controller
{

    public function __invoke(CoachFeedback $coachFeedback)
    {
        try {

            $action = app(DeleteCoachFeedbackAction::class);
            $action->handle($coachFeedback);

            flash(trans('coach.feedback.delete.success'))->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete feedback.', [
                'coachFeedback' => $coachFeedback,
                'exception' => $exception,
            ]);

            flash(trans('coach.feedback.delete.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}

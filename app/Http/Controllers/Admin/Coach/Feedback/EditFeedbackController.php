<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action\UpdateCoachFeedbackAction;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request\CoachFeedbackRequest;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackForm;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackWrapper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditFeedbackController extends Controller
{
    use Feedbackable;

    public function configView(CoachFeedback $coachFeedback)
    {
        $wrapper = new CoachFeedbackWrapper($coachFeedback);

        $form = app(CoachFeedbackForm::class);
        $form->configForEdit($coachFeedback);

        $this->sendCommonDataToView();

        view()->share([
            'coachFeedback' => $coachFeedback,
            'form' => $form,
            'wrapper' => $wrapper,
        ]);

        return view('admin.coach.feedback.form');
    }

    public function update(CoachFeedbackRequest $request, CoachFeedback $coachFeedback)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateCoachFeedbackAction::class);
            $action->handle($request, $coachFeedback);

            DB::commit();

            flash(trans('coach.feedback.update.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update feedback.', [
                'coachFeedback' => $coachFeedback,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.feedback.update.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

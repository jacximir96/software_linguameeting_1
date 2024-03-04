<?php

namespace App\Http\Controllers\Admin\Coach\Feedback;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action\CreateCoachFeedbackAction;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request\CoachFeedbackRequest;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateFeedbackController extends Controller
{

    use Feedbackable;

    public function configView(User $coach)
    {
        $form = app(CoachFeedbackForm::class);
        $form->configForCreate($coach);

        $this->sendCommonDataToView();

        view()->share([
            'coach' => $coach,
            'coachFeedback' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.feedback.form');
    }

    public function create(CoachFeedbackRequest $request, User $coach)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateCoachFeedbackAction::class);
            $feedback = $action->handle($request, $coach);

            DB::commit();

            flash(trans('coach.feedback.create.success'))->success();

            return redirect()->route('get.admin.coach.coach_feedback.edit', $feedback->hashId());

        } catch (\Throwable $exception) {

            Log::error('There is an error when create feedback.', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.feedback.create.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

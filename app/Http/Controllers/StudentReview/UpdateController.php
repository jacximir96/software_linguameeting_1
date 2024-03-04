<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\StudentReview\Action\UpdateStudentReviewAction;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\StudentReviewRequest;
use App\Src\CourseDomain\SessionDomain\StudentReview\Service\StudentReviewForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UpdateController extends Controller
{


    public function configView(StudentReview $sessionFeedback)
    {

        $form = app(StudentReviewForm::class);
        $form->configToEdit($sessionFeedback);

        view()->share([
            'enrollmentSession' => $sessionFeedback->enrollmentSession,
            'sessionFeedback' => $sessionFeedback,
            'form' => $form,
        ]);

        return view('admin.student.session-feedback.form');
    }

    public function update(StudentReviewRequest $request, StudentReview $sessionFeedback)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateStudentReviewAction::class);
            $sessionFeedback = $action->handle($request, $sessionFeedback);

            DB::commit();

            flash(trans('student.enrollment.session.feedback.update_success'))->success();

            return redirect()->route('get.common.enrollments.session.feedback.update', $sessionFeedback->hashId());
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update session feedback', [
                'sessionFeedback' => $sessionFeedback,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.feedback.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

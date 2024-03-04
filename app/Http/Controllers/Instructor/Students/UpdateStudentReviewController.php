<?php

namespace App\Http\Controllers\Instructor\Students;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\StudentReview\Action\UpdateStudentReviewAction;
use App\Src\CourseDomain\SessionDomain\StudentReview\Model\StudentReview;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\StudentReviewRequest;
use App\Src\InstructorDomain\Students\Service\StudentReviewForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class UpdateStudentReviewController extends Controller
{


    public function configView(StudentReview $studentReview)
    {

        $form = app(StudentReviewForm::class);
        $form->configToEdit($studentReview);

        view()->share([
            'enrollmentSession' => $studentReview->enrollmentSession,
            'sessionFeedback' => $studentReview,
            'form' => $form,
        ]);

        return view('admin.student.session-feedback.form');
    }

    public function update(StudentReviewRequest $request, StudentReview $studentReview)
    {
        try {

            DB::beginTransaction();

            $action = app(UpdateStudentReviewAction::class);
            $studentReview = $action->handle($request, $studentReview);

            DB::commit();

            flash(trans('student.enrollment.session.feedback.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when update session feedback', [
                'sessionFeedback' => $studentReview,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.feedback.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\StudentReview;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\StudentReview\Action\CreateStudentReviewAction;
use App\Src\CourseDomain\SessionDomain\StudentReview\Request\StudentReviewRequest;
use App\Src\CourseDomain\SessionDomain\StudentReview\Service\StudentReviewForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CreateController extends Controller
{


    public function configView(EnrollmentSession $enrollmentSession)
    {

        $form = app(StudentReviewForm::class);
        $form->configToCreate($enrollmentSession);

        view()->share([
            'enrollmentSession' => $enrollmentSession,
            'form' => $form,
        ]);

        return view('admin.student.session-feedback.form');
    }

    public function create(StudentReviewRequest $request, EnrollmentSession $enrollmentSession)
    {
        try {

            DB::beginTransaction();

            $action = app(CreateStudentReviewAction::class);
            $sessionFeedback = $action->handle($request, $enrollmentSession);

            DB::commit();

            flash(trans('student.enrollment.session.feedback.create_success'))->success();

            return redirect()->route('get.common.enrollments.session.feedback.update', $sessionFeedback->hashId());
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when create session feedback', [
                'enrollmentSession' => $enrollmentSession,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.enrollment.session.feedback.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

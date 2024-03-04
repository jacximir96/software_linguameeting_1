<?php

namespace App\Http\Controllers\Admin\Course\Coach;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\CourseCoach\Action\AssignCoachAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\AssignCoachRequest;
use App\Src\CourseDomain\CourseCoach\Service\AssignCoachForm;
use Illuminate\Support\Facades\Log;


class AssignCoachController extends Controller
{
    public function configView(Course $course)
    {

        $form = app(AssignCoachForm::class);
        $form->config($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.form_assign_coach');
    }

    public function assign(AssignCoachRequest $request, Course $course)
    {
        try {

            $action = app(AssignCoachAction::class);
            $action->handle($request, $course);

            flash(trans('course.coach.assign.success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when assign coach to course.', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('course.coach.assign.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

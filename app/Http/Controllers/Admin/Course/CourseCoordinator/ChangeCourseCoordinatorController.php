<?php

namespace App\Http\Controllers\Admin\Course\CourseCoordinator;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Action\ChangeCourseCoordinatorAction;
use App\Src\CourseDomain\CourseCoordinator\Request\ChangeCourseCoordinatorRequest;
use App\Src\CourseDomain\CourseCoordinator\Service\ChangeCourseCoordinatorForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeCourseCoordinatorController extends Controller
{
    public function configView(Course $course)
    {
        $form = app(ChangeCourseCoordinatorForm::class);
        $form->config($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.change_course_coordinator_form');
    }

    public function change(ChangeCourseCoordinatorRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(ChangeCourseCoordinatorAction::class);
            $action->handle($request, $course);

            DB::commit();

            flash(trans('course.user.course_coordinator.change_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when change course coordinator', [
                'request' => $request,
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('course.user.course_coordinator.error.on_change'))->error();

            return back()->withInput();
        }
    }
}

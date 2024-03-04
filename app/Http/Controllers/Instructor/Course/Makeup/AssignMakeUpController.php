<?php

namespace App\Http\Controllers\Instructor\Course\Makeup;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Action\AssignMakeUpByInstructorAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\StudentDomain\Makeup\Request\AssignMakeupToCourseByInstructorRequest;
use App\Src\StudentDomain\Makeup\Service\AssignMakeUpByInstructorForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AssignMakeUpController extends Controller
{
    public function configView(Course $course)
    {

        $form = app(AssignMakeUpByInstructorForm::class);
        $form->configForCourse($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.form_assign_make_up_by_instructor');
    }

    public function assign(AssignMakeupToCourseByInstructorRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(AssignMakeUpByInstructorAction::class);
            $action->handle($request, $course, user());

            DB::commit();

            flash(trans('course.makeup.assign.success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when assign make up in a course by instructor.', [
                'section' => $course,
                'request' => $request,
                'instructor' => user(),
                'exception' => $exception,
            ]);

            flash(trans('course.makeup.assign.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

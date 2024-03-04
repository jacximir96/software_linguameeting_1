<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Action\AssignMakeUpAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\AssignMakeUpRequest;
use App\Src\CourseDomain\Course\Service\AssignMakeUpForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AssignMakeUpController extends Controller
{
    public function configView(Course $course)
    {
        $form = app(AssignMakeUpForm::class);
        $form->configForCourse($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.form_assign_make_up');
    }

    public function assign(AssignMakeUpRequest $request, Course $course)
    {
        try {

            DB::beginTransaction();

            $action = app(AssignMakeUpAction::class);
            $action->handle($request, $course, user());

            DB::commit();

            flash(trans('course.makeup.assign.success'))->success();

            return back();
        } catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when assign make up in a course.', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('course.makeup.assign.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

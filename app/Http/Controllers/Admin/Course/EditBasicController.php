<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Action\UpdateBasicAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\CourseBasicRequest;
use App\Src\CourseDomain\Course\Service\CourseBasicForm;
use Illuminate\Support\Facades\Log;

class EditBasicController extends Controller
{
    public function configView(Course $course)
    {
        $form = app(CourseBasicForm::class);
        $form->config($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.form_basic');
    }

    public function update(CourseBasicRequest $request, Course $course)
    {
        try {

            $action = app(UpdateBasicAction::class);
            $action->handle($request, $course);

            flash(trans('course.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update basic course.', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('course.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

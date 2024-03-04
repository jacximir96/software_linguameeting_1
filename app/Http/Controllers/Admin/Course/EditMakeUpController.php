<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Action\UpdateMakeUpAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Request\MakeUpRequest;
use App\Src\CourseDomain\Course\Service\MakeUpForm;
use Illuminate\Support\Facades\Log;

class EditMakeUpController extends Controller
{
    public function configView(Course $course)
    {
        $form = app(MakeUpForm::class);
        $form->config($course);

        view()->share([
            'course' => $course,
            'form' => $form,
        ]);

        return view('admin.course.form_make_up');
    }

    public function update(MakeUpRequest $request, Course $course)
    {
        try {

            $action = app(UpdateMakeUpAction::class);
            $action->handle($request, $course);

            flash(trans('course.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update make up.', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('course.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

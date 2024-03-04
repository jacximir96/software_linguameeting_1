<?php

namespace App\Http\Controllers\Instructor\Admin;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Action\UpdateSimpleInstructorAction;
use App\Src\InstructorDomain\Instructor\Request\UpdateSimpleInstructorRequest;
use App\Src\InstructorDomain\Instructor\Service\InstructorForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class ShowController extends Controller
{
    public function configView(User $instructor)
    {
        $form = app(InstructorForm::class);
        $form->configToEditByUser($instructor);

        view()->share([
            'instructor' => $instructor,
            'form' => $form,
        ]);

        return view('admin.instructor.base_form');
    }

    public function update(UpdateSimpleInstructorRequest $request, User $instructor)
    {
        try {

            $action = app(UpdateSimpleInstructorAction::class);
            $action->handle($request, $instructor);

            flash(trans('instructor.update_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when update basic course.', [
                'instructor' => $instructor,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

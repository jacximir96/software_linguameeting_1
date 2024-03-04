<?php

namespace App\Http\Controllers\Admin\Instructor\TeachingAssistant;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\TeachingAssistant\Action\AssignInstructorToAssistantAction;
use App\Src\InstructorDomain\TeachingAssistant\Request\AssignInstructorToAssistantRequest;
use App\Src\InstructorDomain\TeachingAssistant\Service\AssignInstructorToAssistantForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class AssignInstructorToAssistantController extends Controller
{
    public function configView(User $assistant)
    {
        $form = app(AssignInstructorToAssistantForm::class);
        $form->configToCreate($assistant);

        view()->share([
            'assistant' => $assistant,
            'form' => $form,
        ]);

        return view('admin.instructor.teacher-assistant.assign_instructor_to_assistant_form');
    }

    public function assign(AssignInstructorToAssistantRequest $request, User $assistant)
    {
        try {

            $action = app(AssignInstructorToAssistantAction::class);
            $action->handle($request, $assistant);

            flash(trans('instructor.teacher_assistant.assign_instructor_to_assistant.assign_success'))->success();

            return view('common.feedback_modal');

        } catch (\Throwable $exception) {
            Log::error('There is an error when assign instructro to assistant coordinator', [
                'assistant' => $assistant,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.teacher_assistant.assign_instructor_to_assistant.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\Instructor\TeachingAssistant;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\TeachingAssistant\Action\DeleteInstructorAssignedAction;
use App\Src\InstructorDomain\TeachingAssistant\Model\TeachingAssistant;
use Illuminate\Support\Facades\Log;

class DeleteInstructorAssignedController extends Controller
{
    public function __invoke(TeachingAssistant $teachingAssistant)
    {
        try {

            $action = app(DeleteInstructorAssignedAction::class);
            $action->handle($teachingAssistant);

            flash(trans('instructor.teacher_assistant.assign_instructor_to_assistant.delete_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when deleting instructor to assistant coordinator', [
                'teachingAssistant' => $teachingAssistant,
                'exception' => $exception,
            ]);

            flash(trans('instructor.teacher_assistant.assign_instructor_to_assistant.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}

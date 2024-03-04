<?php

namespace App\Http\Controllers\Api\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\SectionTeachingAssistant\Action\DeleteSectionTeachingAssistantAction;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use Illuminate\Support\Facades\Log;

class DeleteSectionTeachingAssistantController extends Controller
{
    public function __invoke(SectionTeachingAssistant $sectionTeachingAssistant)
    {
        try {

            $action = app(DeleteSectionTeachingAssistantAction::class);
            $action->handle($sectionTeachingAssistant);

            return response(['message' => trans('instructor.teacher_assistant.delete_from_section')], 200);
        } catch (\Throwable $exception) {
            Log::error('There is an error when deleted teaching assistant in a section', [
                'sectionTeachingAssistant' => $sectionTeachingAssistant,
                'exception' => $exception,
            ]);

            return response(['message' => trans('instructor.teacher_assistant.error.on_delete')], 500);
        }
    }
}

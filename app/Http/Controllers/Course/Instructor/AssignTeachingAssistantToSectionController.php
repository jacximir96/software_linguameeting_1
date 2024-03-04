<?php

namespace App\Http\Controllers\Course\Instructor;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SectionTeachingAssistant\Action\AssignSectionAction;
use App\Src\InstructorDomain\Instructor\Request\SectionTeachingAssistantRequest;
use App\Src\InstructorDomain\Instructor\Service\SectionTeachingAssistantForm;
use App\Src\InstructorDomain\TeachingAssistant\Action\CreateTeachingAssistantAction;
use App\Src\UniversityDomain\Instructor\Action\AssignUniversityCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignTeachingAssistantToSectionController extends Controller
{
    public function configView(Section $section)
    {
        $form = app(SectionTeachingAssistantForm::class);
        $form->configToCreate($section);

        view()->share([
            'form' => $form,
            'section' => $section,
        ]);

        return view('admin.instructor.base_form');
    }

    public function create(SectionTeachingAssistantRequest $request, Section $section)
    {
        try {
            DB::beginTransaction();

            $action = app(CreateTeachingAssistantAction::class);
            $teachingAssistant = $action->handle($request, $section->course->university, $section->course->language, user());

            $action = app(AssignUniversityCommand::class);
            $action->handle($section->course->university, $teachingAssistant);

            $action = app(AssignSectionAction::class);
            $action->handle($section, $teachingAssistant);
            DB::commit();

            flash(trans('instructor.teacher_assistant.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when create teacher assistan in a section', [
                'section' => $section,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.teacher_assistant.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

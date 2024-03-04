<?php

namespace App\Http\Controllers\Api\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Action\UpdateSectionAction;
use App\Src\CourseDomain\Section\Exception\AssistantAlreadyAssignedAsInstructor;
use App\Src\CourseDomain\Section\Exception\InstructorAlreadyAssigned;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\Section\Request\SectionRequest;
use App\Src\CourseDomain\SectionTeachingAssistant\Action\AssignSectionAction;
use App\Src\CourseDomain\SectionTeachingAssistant\Exception\TeachingAssistantExistsInSection;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateFromCoachingFormController extends Controller
{
    public function __invoke(SectionRequest $request, Section $section)
    {
        try {
            DB::beginTransaction();

            $action = app(UpdateSectionAction::class);
            $action->handle($request, $section, user());

            if ($request->filled('teaching_assistant_id')) {
                $teachingAssistant = User::find($request->teaching_assistant_id);

                $action = app(AssignSectionAction::class);
                $action->handle($section, $teachingAssistant);
            }

            DB::commit();

            return response('', 200);
        } catch (InstructorAlreadyAssigned $exception) {
            return response($exception->jsonResponse(), 422);
        } catch (AssistantAlreadyAssignedAsInstructor $exception) {
            return response($exception->jsonResponse(), 422);
        } catch (TeachingAssistantExistsInSection $exception) {
            return response($exception->jsonResponse(), 422);
        } catch (\Throwable $exception) {

            Log::error('There is an error when update section', [
                'request' => $request,
                'section' => $section,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}

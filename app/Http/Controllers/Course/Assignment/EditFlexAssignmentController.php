<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Repository\TemplateRepository;
use App\Src\CourseDomain\Assignment\Action\Flex\ReplicateAssignmentInFlexAction;
use App\Src\CourseDomain\Assignment\Action\Flex\UpdateFlexAssignmentAction;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Assignment\Request\FormAssignmentRequest;
use App\Src\CourseDomain\Assignment\Service\FormFlexAssignment;
use App\Src\CourseDomain\CoachingForm\Service\InstructionsFinder;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Modal View
 */
class EditFlexAssignmentController extends Controller
{
    private AssignmentRepository $assignmentRepository;

    private TemplateRepository $templateRepository;

    public function __construct(AssignmentRepository $assignmentRepository, TemplateRepository $templateRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->templateRepository = $templateRepository;
    }

    public function configView(Section $section, int $sessionOrder)
    {

        $form = app(FormFlexAssignment::class);
        $form->config($section, $sessionOrder);

        $assignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($section, $sessionOrder);
        $instructionsFinder = new InstructionsFinder();

        $templates = $this->templateRepository->all();

        view()->share([
            'assignment' => $assignment,
            'course' => $section->course,
            'form' => $form,
            'formId' => $sessionOrder,
            'instructionsFinder' => $instructionsFinder,
            'section' => $section,
            'sessionDescription' => $sessionOrder,
            'sessionOrder' => $sessionOrder,
            'templates' => $templates,
        ]);

        return view('admin.course.coaching-form.course-assignment.modal_assignment_form');
    }

    public function update(FormAssignmentRequest $request, Section $section, int $sessionOrder)
    {
        try {
            DB::beginTransaction();

            $flexSession = new FlexSession($sessionOrder);

            $action = app(UpdateFlexAssignmentAction::class);
            $action->handle($request, $section, $flexSession);

            if ($request->saveAllSessions()) {

                $course = $section->course;
                $originalAssignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($section, $sessionOrder);

                $action = app(ReplicateAssignmentInFlexAction::class);
                $action->handle($course, $originalAssignment);
            }

            DB::commit();

            flash('Assignments update succesfully')->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update section assignments in flex course', [
                'section' => $section,
                'sessionOrder' => $sessionOrder,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();

            return back();
        }
    }
}

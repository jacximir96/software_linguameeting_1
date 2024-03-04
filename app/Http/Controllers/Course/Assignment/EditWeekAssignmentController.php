<?php

namespace App\Http\Controllers\Course\Assignment;

use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Repository\TemplateRepository;
use App\Src\CourseDomain\Assignment\Action\Week\ReplicateAssignmentInWeekAction;
use App\Src\CourseDomain\Assignment\Action\Week\UpdateAssignmentInWeekAction;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Assignment\Request\FormAssignmentRequest;
use App\Src\CourseDomain\Assignment\Service\FormWeekAssignment;
use App\Src\CourseDomain\CoachingForm\Service\InstructionsFinder;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Modal View
 */
class EditWeekAssignmentController extends Controller
{
    private AssignmentRepository $assignmentRepository;

    private TemplateRepository $templateRepository;

    public function __construct(AssignmentRepository $assignmentRepository, TemplateRepository $templateRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->templateRepository = $templateRepository;
    }

    public function configView(Section $section, CoachingWeek $coachingWeek)
    {

        $form = app(FormWeekAssignment::class);
        $form->config($section, $coachingWeek);

        $assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);
        $instructionsFinder = new InstructionsFinder();

        $templates = $this->templateRepository->all();

        view()->share([
            'assignment' => $assignment,
            'coachingWeek' => $coachingWeek,
            'course' => $section->course,
            'form' => $form,
            'formId' => $coachingWeek->id,
            'instructionsFinder' => $instructionsFinder,
            'section' => $section,
            'sessionDescription' => $coachingWeek->writePeriod(),
            'templates' => $templates,
        ]);

        return view('admin.course.coaching-form.course-assignment.modal_assignment_form');
    }

    public function update(FormAssignmentRequest $request, Section $section, CoachingWeek $coachingWeek)
    {
        try {
            DB::beginTransaction();

            $action = app(UpdateAssignmentInWeekAction::class);
            $action->handle($request, $section, $coachingWeek);

            if ($request->saveAllSessions()) {

                $course = $section->course;
                $originalAssignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);

                $action = app(ReplicateAssignmentInWeekAction::class);
                $action->handle($course, $originalAssignment);
            }

            DB::commit();

            flash('Assignments update succesfully')->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update assignments', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_update'))->error();

            return back();
        }
    }
}

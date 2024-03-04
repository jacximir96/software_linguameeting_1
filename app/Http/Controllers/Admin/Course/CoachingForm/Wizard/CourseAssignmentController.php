<?php

namespace App\Http\Controllers\Admin\Course\CoachingForm\Wizard;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Guide\Repository\GuideRepository;
use App\Src\ConversationGuideDomain\Template\Repository\TemplateRepository;
use App\Src\CourseDomain\CoachingForm\Action\CourseAssignment\ApplyAssignmentToAllSectionInFlexCourseAction;
use App\Src\CourseDomain\CoachingForm\Action\CourseAssignment\ApplyAssignmentToAllSectionInWeekCourseAction;
use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\CoachingFormBreadcrumb;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentForAllRequest;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\CoachingForm\Service\InstructionsFinder;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\OneOnOneWeekPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupFlexPresenter;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter\SmallGroupWeekPresenter;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Section\Model\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseAssignmentController extends Controller
{
    use Breadcrumable, Summarizable;

    private CourseRepository $courseRepository;

    private TemplateRepository $templateRepository;

    private GuideRepository $guideRepository;

    public function __construct(CourseRepository $courseRepository, TemplateRepository $templateRepository, GuideRepository $guideRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->templateRepository = $templateRepository;
        $this->guideRepository = $guideRepository;
    }

    public function configView(Course $course)
    {
        try {
            $course->load($this->courseRepository->relationsWithSections());

            $presenter = $this->obtainPresenter($course);
            $viewData = $presenter->handle($course);

            if (request()->has('sectionToExpand') and $viewData->hasSectionsToOpen()) {
                if (is_numeric(request()->get('sectionToExpand'))) {
                    $viewData->setForcedOpenSectionId(request()->get('sectionToExpand'));
                }
            }

            $this->buildCourseSummaryFromCourse($course);

            $this->buildBreadcrumbAndSendToView(CoachingFormBreadcrumb::SLUG);

            $instructionsFinder = new InstructionsFinder();

            $templates = $this->templateRepository->all();

            $guideByDefault = $this->obtainGuideByDefault($course);

            view()->share([
                'allowsFullEdition' => $course->allowsFullEdition(user()),
                'course' => $course,
                'guide' => $guideByDefault,
                'instructionsFinder' => $instructionsFinder,
                'isSmallGroup' => $course->conversationPackage->sessionType->isSmallGroup(),
                'maxFileSizeInKB' => config('linguameeting.files.max_upload_size_in_KB'),
                'templates' => $templates,
                'viewData' => $viewData,
            ]);

            return view('admin.course.coaching-form.course_assignment');

        } catch (\Throwable $exception) {

            Log::error('There is an error when show course assignment', [
                'course' => $course,
                'exception' => $exception,
            ]);

            flash(trans('coaching_form.exception.error_general'))->error();

            return back();
        }
    }

    //button next | ok (individually updated with api)
    public function updateWeekSmallGroup(AssignmentRequest $request, Course $course)
    {
        flash(trans('coaching_form.step_feedback.course_assignment.success'))->success();

        return redirect()->route('get.admin.course.coaching_form.course_summary', $course->hashId());
    }

    //button next | ok (individually updated with api)
    public function updateFlexSmallGroup(AssignmentRequest $request, Course $course)
    {
        flash(trans('coaching_form.step_feedback.course_assignment.success'))->success();

        return redirect()->route('get.admin.course.coaching_form.course_summary', $course->hashId());
    }

    //button next | ok (individually updated with api)
    public function updateWeekOneOnOne(AssignmentRequest $request, Course $course)
    {
        flash(trans('coaching_form.step_feedback.course_assignment.successs'))->success();

        return redirect()->route('get.admin.course.coaching_form.course_summary', $course->hashId());
    }

    //button next | ok (individually updated with api)
    public function updateFlexOneOnOne(AssignmentRequest $request, Course $course)
    {
        flash(trans('coaching_form.step_feedback.course_assignment.success'))->success();

        return redirect()->route('get.admin.course.coaching_form.course_summary', $course->hashId());
    }

    //apply assignments to all (ajax request)
    public function updateOneOnOneForAll(AssignmentForAllRequest $request)
    {

        try {

            DB::beginTransaction();

            $section = Section::find($request->section_id);

            if ($section->course->isFlex()) {
                $action = app(ApplyAssignmentToAllSectionInFlexCourseAction::class);
                $action->handle($request);
            } else {
                $action = app(ApplyAssignmentToAllSectionInWeekCourseAction::class);
                $action->handle($request);
            }

            DB::commit();

            return response()->json([
                'redirect_to' => route('get.admin.course.coaching_form.course_summary', $section->course->hashId()),
            ], 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when save assignments for one on one and flex for all sections', [

                'request' => $request,
                'exception' => $exception,
            ]);

            return response()->json('Error saving assignments', 500);
        }
    }

    private function obtainPresenter(Course $course)
    {

        if ($course->isFlex()) {

            if ($course->conversationPackage->sessionType->isSmallGroup()) {
                return app(SmallGroupFlexPresenter::class);
            }

            return app(OneOnOneFlexPresenter::class); //**
        }

        //course with coaching weeks...

        if ($course->conversationPackage->sessionType->isSmallGroup()) {
            return app(SmallGroupWeekPresenter::class);
        }

        return app(OneOnOneWeekPresenter::class);
    }

    private function obtainGuideByDefault(Course $course)
    {

        $guide = $course->conversationGuide;

        if ($guide->hasLingroWithoutGuide()) {
            return $this->guideRepository->obtainLinguameetingSpanish();

        }

        return $guide;
    }
}

<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Action\AssignCourseCoordinatorAction;
use App\Src\CourseDomain\CourseCoordinator\Service\CoursesCoordinatorForm;
use App\Src\InstructorDomain\Instructor\Action\CreateCourseCoordinatorAction;
use App\Src\InstructorDomain\Instructor\Request\CourseCoordinatorRequest;
use App\Src\UniversityDomain\Instructor\Action\AssignUniversityCommand;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Given a teacher, assign it to one or more courses
 *
 * Class CreateCourseCoordinatorController
 */
class AssignCoursesCoordinatorController extends Controller
{
    use Breadcrumable;

    public function configView(User $instructor)
    {
        $form = app(CoursesCoordinatorForm::class);
        $form->config($instructor);

        view()->share([
            'form' => $form,
            'university' => $course,
        ]);

        return view('admin.instructor.base_form');
    }

    public function create(CourseCoordinatorRequest $request, Course $course)
    {
        try {
            DB::beginTransaction();

            $action = app(CreateCourseCoordinatorAction::class);
            $coordinator = $action->handle($request, $course->university, $course->language);

            $action = app(AssignUniversityCommand::class);
            $action->handle($course->university, $coordinator);

            $action = app(AssignCourseCoordinatorAction::class);
            $action->handle($course, $coordinator);

            DB::commit();

            flash(trans('instructor.coordinator.create_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when create coordinator', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.coordinator.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

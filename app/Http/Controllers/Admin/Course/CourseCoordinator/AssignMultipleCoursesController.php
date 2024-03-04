<?php

namespace App\Http\Controllers\Admin\Course\CourseCoordinator;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\CourseCoordinator\Action\AssignMultipleCoursesAction;
use App\Src\CourseDomain\CourseCoordinator\Request\AssignMultipleCoursesRequest;
use App\Src\CourseDomain\CourseCoordinator\Service\AssignMultipleCoursesForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignMultipleCoursesController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {

        $this->courseRepository = $courseRepository;
    }

    public function configView(User $instructor)
    {

        $form = app(AssignMultipleCoursesForm::class);
        $form->config($instructor);

        view()->share([
            'instructor' => $instructor,
            'form' => $form,
        ]);

        return view('admin.instructor.course.assign_multiple_courses');
    }

    public function assign(AssignMultipleCoursesRequest $request, User $instructor)
    {
        try {

            $courses = $this->courseRepository->obtainByIds($request->course_id, []);

            DB::beginTransaction();

            $action = app(AssignMultipleCoursesAction::class);
            $action->handle($courses, $instructor);

            DB::commit();

            flash(trans('course.user.course_coordinator.assign_multiple_courses_success'))->success();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when assigning multiple courses to coordinator', [
                'request' => $request,
                'instructor' => $instructor,
                'exception' => $exception,
            ]);

            flash(trans('course.user.course_coordinator.error.on_assign_multiple_courses'))->error();

            return back()->withInput();
        }
    }
}

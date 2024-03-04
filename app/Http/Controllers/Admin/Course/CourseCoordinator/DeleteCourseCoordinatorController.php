<?php

namespace App\Http\Controllers\Admin\Course\CourseCoordinator;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Action\DeleteCourseCoordinatorAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class DeleteCourseCoordinatorController extends Controller
{
    public function __invoke(Course $course, User $instructor)
    {

        try {

            $action = app(DeleteCourseCoordinatorAction::class);
            $action->handle($course, $instructor);

            flash(trans('course.user.course_coordinator.delete_success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when delete course coordinator', [
                'course' => $course,
                'coordinator' => $instructor,
                'exception' => $exception,
            ]);

            flash(trans('course.user.course_coordinator.error.on_delete'))->error();

            return back();
        }
    }
}

<?php

namespace App\Http\Controllers\Api\CourseCoordinator;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Action\DeleteCourseCoordinatorAction;
use Illuminate\Support\Facades\Log;

class RemoveCourseCoordinatorController extends Controller
{
    public function __invoke(Course $course)
    {

        try {

            $action = app(DeleteCourseCoordinatorAction::class);
            $action->handle($course);

            return response('Course coordinator removed successfully', 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when remove course coordinator', [
                'course' => $course,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\CourseCoordinator;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Action\AssignCourseCoordinatorAction;
use App\Src\CourseDomain\CourseCoordinator\Action\DeleteCourseCoordinatorAction;
use App\Src\CourseDomain\CourseCoordinator\Request\AssignCourseCoordinatorRequest;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignCourseCoordinatorController extends Controller
{
    public function __invoke(AssignCourseCoordinatorRequest $request, Course $course)
    {

        try {

            DB::beginTransaction();

            $coordinator = User::find($request->coordinator_id);

            $action = app(DeleteCourseCoordinatorAction::class);
            $action->handle($course);

            $action = app(AssignCourseCoordinatorAction::class);
            $action->handle($course, $coordinator);

            DB::commit();

            return response('Coordinator assigned successfully', 200);

        } catch (\Throwable $exception) {

            DB::rollBack();

            Log::error('There is an error when assign course coordinator', [
                'course' => $course,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('', 500);
        }
    }
}

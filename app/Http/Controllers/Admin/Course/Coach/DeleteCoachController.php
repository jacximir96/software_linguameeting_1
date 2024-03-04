<?php

namespace App\Http\Controllers\Admin\Course\Coach;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoach\Action\DeleteCoachAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DeleteCoachController extends Controller
{

    public function __invoke(Course $course, User $coach)
    {
        try {

            $action = app(DeleteCoachAction::class);
            $action->handle($course, $coach);

            flash(trans('course.coach.delete.success'))->success();

            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when deleting coach to course.', [
                'course' => $course,
                'coach' => $coach,
                'exception' => $exception,
            ]);

            flash(trans('course.coach.delete.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

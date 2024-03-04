<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\DenyAccess\Action\ChangeAccessAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class ChangeAccessController extends Controller
{
    public function __invoke(Course $course, User $user)
    {

        try {

            $action = app(ChangeAccessAction::class);
            $action->handle($course, $user);

            flash(trans('course.user.change_access_success'))->success();

            //return redirect()->route('get.admin.instructor.edit', $user);
            return back();
        } catch (\Throwable $exception) {

            Log::error('There is an error when change access to course by user', [
                'course' => $course,
                'user' => $user,
                'exception' => $exception,
            ]);

            flash(trans('course.user.error.on_change_access'))->error();

            return back();
        }
    }
}

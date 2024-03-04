<?php

namespace App\Http\Controllers\Instructor\Admin;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\Instructor\Action\DeleteInstructorAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{
    public function configView(User $user)
    {
        view()->share([
            'user' => $user,
        ]);

        return view('instructor.admin.delete');
    }

    public function delete(User $user)
    {
        try {
            $action = app(DeleteInstructorAction::class);
            $action->handle($user);

            flash(trans('instructor.delete_success'))->success();

            return view('common.feedback_modal');
        } catch (\Throwable $exception) {
            Log::error('There is an error when delete instructor', [
                'exception' => $exception,
            ]);

            flash(trans('instructor.error.on_delete'))->error();

            return back();
        }
    }
}

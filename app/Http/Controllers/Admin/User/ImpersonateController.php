<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class ImpersonateController extends Controller
{
    public function __invoke(User $user)
    {
        try {

            user()->impersonate($user);

            flash(trans('user.impersonate_success'))->success();

            if (user()->isCoach()) {
                return redirect()->route('get.coach.dashboard');
            } elseif (user()->isStudent()) {
                return redirect()->route('get.student.dashboard');
            }
            elseif(user()->isInstructor()){
                return redirect()->route('get.instructor.dashboard');
            }

            return redirect()->route('get.admin.dashboard.index');

        } catch (\Throwable $exception) {
            Log::error('There is an error when simulation user', [
                'user' => $user,
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_impersonate'))->error();

            return back();
        }
    }
}

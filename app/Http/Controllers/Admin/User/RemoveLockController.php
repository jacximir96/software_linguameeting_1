<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\RemoveLockAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class RemoveLockController extends Controller
{
    public function __invoke(User $user)
    {
        try {

            $action = app(RemoveLockAction::class);
            $action->handle($user);

            flash(trans('user.throttle.remove_success'))->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error unlocking the user', [
                'user' => $user,
                'exception' => $exception,
            ]);

            flash(trans('user.throttle.remove_error'))->error();

            return back();

        }
    }
}

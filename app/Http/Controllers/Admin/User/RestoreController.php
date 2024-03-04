<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\RestoreUserAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class RestoreController extends Controller
{
    public function __invoke(int $userId)
    {
        try {

            $user = User::withTrashed()->find($userId);

            $action = app(RestoreUserAction::class);
            $action->handle($user);

            flash(trans('user.restore_success'))->success();

            return back();
        } catch (\Throwable $exception) {
            Log::error('There is an error when restore user', [
                'exception' => $exception,
            ]);

            flash(trans('user.error.on_restore'))->error();

            return back();
        }
    }
}

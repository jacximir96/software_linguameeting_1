<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Src\UserDomain\User\Action\ChangeStatusAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class ChangeStatusController extends Controller
{
    public function __invoke(User $user)
    {
        try {

            $action = app(ChangeStatusAction::class);
            $action->handle($user);

            return response('Status changed successfully', 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when changing user status', [
                'user' => $user,
                'exception' => $exception,
            ]);

            return response('Error while changing user status ', 500);
        }
    }
}

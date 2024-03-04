<?php

namespace App\Http\Controllers\Api\Coach\Coordinator;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachCoordinator\Action\ChangeCoordinatorAction;
use App\Src\CoachDomain\CoachCoordinator\Request\ChangeCoordinatorRequest;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;


class ChangeCoordinatorController extends Controller
{
    public function __invoke(ChangeCoordinatorRequest $request, User $coach)
    {

        try {

            $coordinator = User::find($request->coordinator_id);

            $action = app(ChangeCoordinatorAction::class);
            $action->handle($coach, $coordinator);

            return response('Coordinator changed successfully', 200);

        } catch (\Throwable $exception) {

            Log::error('There is an error when changing coach coordinator', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            return response('Error while changing coordinator', 500);
        }
    }
}

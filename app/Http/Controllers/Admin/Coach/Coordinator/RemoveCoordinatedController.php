<?php

namespace App\Http\Controllers\Admin\Coach\Coordinator;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachCoordinator\Action\RemoveCoordinatedAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class RemoveCoordinatedController extends Controller
{
    public function __invoke(User $coachCoordinator, User $coach)
    {
        try {

            $action = app(RemoveCoordinatedAction::class);
            $action->handle($coachCoordinator, $coach);

            flash(trans('coach.coordinator.remove_assigned_successfully'))->success();

            return back();

        } catch (\Throwable $exception) {

            Log::error('There is an error when remove coach from coordinator', [
                'coach' => $coachCoordinator,
                'coach' => $coach,
                'exception' => $exception,
            ]);

            flash(trans('coach.coordinator.error.on_remove'))->error();

            return back()->withInput();
        }
    }
}

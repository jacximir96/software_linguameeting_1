<?php

namespace App\Http\Controllers\Admin\Coach\Coordinator;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachCoordinator\Action\AssignCoordinatorAction;
use App\Src\CoachDomain\CoachCoordinator\Exception\CoachAlreadyBelongsToCoordinator;
use App\Src\CoachDomain\CoachCoordinator\Request\AssignCoordinatorRequest;
use App\Src\CoachDomain\CoachCoordinator\Service\AssignCoordinatorForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class AssignCoordinatorController extends Controller
{
    public function configView(User $coach)
    {

        $form = app(AssignCoordinatorForm::class);
        $form->config($coach);

        view()->share([
            'coach' => $coach,
            'form' => $form,
        ]);

        return view('admin.coach.assign_coordinator_form');
    }

    public function assign(AssignCoordinatorRequest $request, User $coach)
    {
        try {

            $coachCoordinator = User::find($request->coach_id);

            $action = app(AssignCoordinatorAction::class);
            $action->handle($coachCoordinator, $coach);

            flash(trans('coach.coordinator.assigned_successfully'))->success();

            return view('common.feedback_modal');

        } catch (CoachAlreadyBelongsToCoordinator $exception) {

            flash(trans('coach.coordinator.coach_already_assigned'))->warning();

            return back()->withInput();
        } catch (\Throwable $exception) {

            Log::error('There is an error when assign coach to coach coordinator', [
                'coach' => $coach,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.coordinator.error.on_assign'))->error();

            return back()->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\Coach\Coordinator;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachCoordinator\Action\AssignCoordinatedAction;
use App\Src\CoachDomain\CoachCoordinator\Exception\CoachAlreadyBelongsToCoordinator;
use App\Src\CoachDomain\CoachCoordinator\Request\AssignCoordinatedRequest;
use App\Src\CoachDomain\CoachCoordinator\Service\AssignCoordinatedForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\Log;

class AssignCoordinatedController extends Controller
{
    public function configView(User $coachCoordinator)
    {

        $form = app(AssignCoordinatedForm::class);
        $form->config($coachCoordinator);

        view()->share([
            'coach' => $coachCoordinator,
            'form' => $form,
        ]);

        return view('admin.coach.assign_coordinated_form');
    }

    public function assign(AssignCoordinatedRequest $request, User $coachCoordinator)
    {
        try {
            $coach = User::find($request->coach_id);

            $action = app(AssignCoordinatedAction::class);
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

<?php

namespace App\Http\Controllers\Admin\Coach;


use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Action\DeleteCoachAction;
use App\Src\CourseDomain\SessionDomain\Session\Exception\CoachHasPendingSession;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteController extends Controller
{

    public function __invoke(User $coach)
    {
        try {

            DB::beginTransaction();

            $action = app(DeleteCoachAction::class);
            $action->handle($coach);

            DB::commit();

            flash(trans('coach.delete_success'))->success();

            return back();
        }
        catch (CoachHasPendingSession $exception){

            flash(trans('coach.error.delete_error_coach_has_pending_sessions', ['coach' => $coach->writeFullName()]))->error();

            return back();
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when delete coach', [
                'coach' => $coach,
                'exception' => $exception,
            ]);

            flash(trans('coach.error.on_delete'))->error();

            return back();
        }
    }
}

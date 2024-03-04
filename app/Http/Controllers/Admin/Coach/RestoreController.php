<?php
namespace App\Http\Controllers\Admin\Coach;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\Coach\Action\RestoreCoachAction;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RestoreController extends Controller
{

    public function __invoke(User $coach)
    {
        try {

            DB::beginTransaction();

            $action = app(RestoreCoachAction::class);
            $action->handle($coach);

            DB::commit();

            flash(trans('coach.restore_success'))->success();

            return back();
        }
        catch (\Throwable $exception) {

            DB::rollback();

            Log::error('There is an error when restore coach', [
                'coach' => $coach,
                'exception' => $exception,
            ]);

            flash(trans('coach.error.on_delete'))->error();

            return back();
        }
    }
}

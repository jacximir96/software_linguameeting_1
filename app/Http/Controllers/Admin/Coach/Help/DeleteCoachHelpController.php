<?php

namespace App\Http\Controllers\Admin\Coach\Help;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachHelp\Action\DeleteCoachHelpAction;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use Illuminate\Support\Facades\Log;


class DeleteCoachHelpController extends Controller
{

    public function __invoke(CoachHelp $coachHelp)
    {
        try {

            $action = app(DeleteCoachHelpAction::class);
            $action->handle($coachHelp);

            flash(trans('coach.help.delete.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when delete coach help.', [
                'coachHelp' => $coachHelp,
                'exception' => $exception,
            ]);

            flash(trans('coach.help.delete.error.on_delete'))->error();

            return back()->withInput();
        }
    }
}

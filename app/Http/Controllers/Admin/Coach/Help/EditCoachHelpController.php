<?php

namespace App\Http\Controllers\Admin\Coach\Help;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachHelp\Action\UpdateCoachHelpAction;
use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\CoachDomain\CoachHelp\Request\CoachHelpRequest;
use App\Src\CoachDomain\CoachHelp\Service\CoachHelpForm;
use Illuminate\Support\Facades\Log;


class EditCoachHelpController extends Controller
{

    public function configView(CoachHelp $coachHelp)
    {
        $form = app(CoachHelpForm::class);
        $form->configForEdit($coachHelp);

        view()->share([
            'coachHelp' => $coachHelp,
            'form' => $form,
        ]);

        return view('admin.coach.help.form');
    }

    public function update(CoachHelpRequest $request, CoachHelp $coachHelp)
    {
        try {

            $action = app(UpdateCoachHelpAction::class);
            $action->handle($request, $coachHelp);

            flash(trans('coach.help.update.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update coach help.', [
                'coachHelp' => $coachHelp,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.help.update.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

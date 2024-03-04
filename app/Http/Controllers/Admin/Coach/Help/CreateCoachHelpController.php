<?php

namespace App\Http\Controllers\Admin\Coach\Help;

use App\Http\Controllers\Controller;
use App\Src\CoachDomain\CoachHelp\Action\CreateCoachHelpAction;
use App\Src\CoachDomain\CoachHelp\Request\CoachHelpRequest;
use App\Src\CoachDomain\CoachHelp\Service\CoachHelpForm;
use Illuminate\Support\Facades\Log;


class CreateCoachHelpController extends Controller
{

    public function configView()
    {
        $form = app(CoachHelpForm::class);
        $form->configForCreate();

        view()->share([
            'form' => $form,
        ]);

        return view('admin.coach.help.form');
    }

    public function create(CoachHelpRequest $request)
    {
        try {

            $action = app(CreateCoachHelpAction::class);
            $action->handle($request);

            flash(trans('coach.help.create.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when create coach help.', [
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('coach.help.create.error.on_create'))->error();

            return back()->withInput();
        }
    }
}

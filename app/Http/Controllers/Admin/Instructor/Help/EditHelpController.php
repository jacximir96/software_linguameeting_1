<?php

namespace App\Http\Controllers\Admin\Instructor\Help;

use App\Http\Controllers\Controller;
use App\Src\InstructorDomain\InstructorHelp\Action\UpdateInstructorHelpAction;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;
use App\Src\InstructorDomain\InstructorHelp\Request\InstructorHelpRequest;
use App\Src\InstructorDomain\InstructorHelp\Service\InstructorHelpForm;
use Illuminate\Support\Facades\Log;


class EditHelpController extends Controller
{

    public function configView(InstructorHelp $instructorHelp)
    {
        $form = app(InstructorHelpForm::class);
        $form->configForEdit($instructorHelp);

        view()->share([
            'instructorHelp' => $instructorHelp,
            'form' => $form,
        ]);

        return view('admin.instructor.help.form');
    }

    public function update(InstructorHelpRequest $request, InstructorHelp $instructorHelp)
    {
        try {

            $action = app(UpdateInstructorHelpAction::class);
            $action->handle($request, $instructorHelp);

            flash(trans('instructor.help.update.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update instructor help.', [
                'instructorHelp' => $instructorHelp,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('instructor.help.update.error.on_update'))->error();

            return back()->withInput();
        }
    }
}

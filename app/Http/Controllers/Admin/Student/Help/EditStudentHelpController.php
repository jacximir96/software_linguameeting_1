<?php

namespace App\Http\Controllers\Admin\Student\Help;

use App\Http\Controllers\Controller;
use App\Src\StudentDomain\StudentHelp\Action\UpdateStudentHelpAction;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;
use App\Src\StudentDomain\StudentHelp\Request\StudentHelpRequest;
use App\Src\StudentDomain\StudentHelp\Service\StudentHelpForm;
use Illuminate\Support\Facades\Log;


class EditStudentHelpController extends Controller
{

    public function configView(StudentHelp $studentHelp)
    {
        $form = app(StudentHelpForm::class);
        $form->configForEdit($studentHelp);

        view()->share([
            'studentHelp' => $studentHelp,
            'form' => $form,
        ]);

        return view('admin.student.help.form');
    }

    public function update(StudentHelpRequest $request, StudentHelp $studentHelp)
    {
        try {

            $action = app(UpdateStudentHelpAction::class);
            $action->handle($request, $studentHelp);

            flash(trans('student.help.update.success'))->success();

            return back()->withInput();

        } catch (\Throwable $exception) {

            Log::error('There is an error when update student help.', [
                'studentHelp' => $studentHelp,
                'request' => $request,
                'exception' => $exception,
            ]);

            flash(trans('student.help.update.error.on_update'))->error();

            return back()->withInput();
        }
    }
}
